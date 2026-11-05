<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Admin\FieldMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Satu controller untuk semua data di backoffice.
 * Daftar field setiap data diatur di config/admin.php.
 */
class ResourceController extends Controller
{
    protected function config(string $resource): array
    {
        $config = config("admin.resources.$resource");
        abort_unless($config, 404);

        return $config + ['key' => $resource];
    }

    public function index(Request $request, string $resource)
    {
        $config = $this->config($resource);
        $model = $config['model'];
        [$col, $dir] = $config['order'] ?? ['sort', 'asc'];

        $query = $model::query()->orderBy($col, $dir)->orderBy('id');
        if ($search = $request->query('q')) {
            $query->where($config['title'], 'like', '%'.$search.'%');
        }

        return view('admin.resource.index', [
            'config' => $config,
            'items'  => $query->paginate(25)->withQueryString(),
        ]);
    }

    public function create(string $resource)
    {
        $config = $this->config($resource);
        $item = new $config['model'];

        // Nilai awal yang wajar untuk data baru
        foreach ($config['fields'] as $field) {
            if (in_array($field['name'], ['is_active', 'is_published'], true)) {
                $item->{$field['name']} = true;
            }
            if ($field['name'] === 'published_at') {
                $item->published_at = now();
            }
            if ($field['name'] === 'author') {
                $item->author = 'Tim '.\App\Models\Setting::get('company_name', 'Enigma Works Indonesia');
            }
        }

        return view('admin.resource.form', ['config' => $config, 'item' => $item]);
    }

    public function store(Request $request, string $resource)
    {
        $config = $this->config($resource);
        $item = new $config['model'];
        $this->fill($request, $config, $item);
        $item->save();

        return redirect()->route('admin.resource.edit', [$resource, $item->id])->with('status', ucfirst($config['singular']).' ditambahkan.');
    }

    public function edit(string $resource, int $id)
    {
        $config = $this->config($resource);

        return view('admin.resource.form', ['config' => $config, 'item' => $config['model']::findOrFail($id)]);
    }

    public function update(Request $request, string $resource, int $id)
    {
        $config = $this->config($resource);
        $item = $config['model']::findOrFail($id);
        $this->fill($request, $config, $item);
        $item->save();

        return redirect()->route('admin.resource.edit', [$resource, $item->id])->with('status', 'Perubahan disimpan.');
    }

    public function destroy(string $resource, int $id)
    {
        $config = $this->config($resource);
        $item = $config['model']::findOrFail($id);

        foreach ($config['fields'] as $field) {
            if (($field['type'] ?? '') === 'image' && $item->{$field['name']}) {
                Storage::disk('public')->delete($item->{$field['name']});
            }
        }
        $item->delete();

        return redirect()->route('admin.resource.index', $resource)->with('status', ucfirst($config['singular']).' dihapus.');
    }

    protected function fill(Request $request, array $config, $item): void
    {
        // Slug otomatis dari judul bila dikosongkan
        if ($request->has('slug') && blank($request->input('slug'))) {
            $request->merge(['slug' => Str::slug((string) $request->input($config['title']))]);
        }

        $rules = FieldMapper::rules($config['fields']);
        if (isset($rules['slug'])) {
            $rules['slug'] .= '|'.Rule::unique($item->getTable(), 'slug')->ignore($item->id);
        }
        $request->validate($rules);

        foreach ($config['fields'] as $field) {
            $item->{$field['name']} = FieldMapper::fromRequest($field, $request, $item->{$field['name']});
        }
    }
}

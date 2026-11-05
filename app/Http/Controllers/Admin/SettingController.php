<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Admin\FieldMapper;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit(?string $group = null)
    {
        $groups = config('admin.settings');
        $group = $group ?? array_key_first($groups);
        abort_unless(isset($groups[$group]), 404);

        return view('admin.settings', [
            'groups' => $groups,
            'group'  => $group,
            'fields' => $groups[$group]['fields'],
            'values' => Setting::allCached(),
        ]);
    }

    public function update(Request $request, string $group)
    {
        $groups = config('admin.settings');
        abort_unless(isset($groups[$group]), 404);
        $fields = $groups[$group]['fields'];

        $request->validate(FieldMapper::rules($fields));

        $values = [];
        foreach ($fields as $field) {
            $current = Setting::get($field['name']);
            $value = FieldMapper::fromRequest($field, $request, $current);
            // Simpan pilihan ya/tidak sebagai '1' atau '0'
            $values[$field['name']] = ($field['type'] ?? '') === 'boolean' ? ($value ? '1' : '0') : $value;
        }
        Setting::put($values);

        return redirect()->route('admin.settings.edit', $group)->with('status', 'Pengaturan disimpan.');
    }
}

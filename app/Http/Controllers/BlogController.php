<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Seo;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, ?string $category = null)
    {
        if ($category && ! isset(Post::CATEGORIES[$category])) {
            abort(404);
        }

        $posts = Post::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->paginate(9)
            ->withPath($request->url());

        $label = $category ? Post::CATEGORIES[$category] : null;
        $heading = $label ? "Artikel $label untuk Rumah Sakit" : 'Blog SIMRS, BPJS, dan SATUSEHAT';
        $page = $posts->currentPage();

        return view('blog.index', [
            'posts'      => $posts,
            'categories' => Post::CATEGORIES,
            'active'     => $category,
            'heading'    => $heading,
            'seo'        => Seo::meta([
                'title'       => Seo::title($heading.($page > 1 ? " (halaman $page)" : '')),
                'description' => 'Artikel praktis tentang SIMRS, bridging BPJS Kesehatan, integrasi SATUSEHAT, dan infrastruktur IT rumah sakit.',
                'canonical'   => $page > 1 ? $request->url().'?page='.$page : $request->url(),
            ]),
            'schema' => [Seo::breadcrumb(array_values(array_filter([
                ['Beranda', route('home')],
                ['Blog', $label ? route('blog.index') : null],
                $label ? [$label, null] : null,
            ])))],
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        return view('blog.show', [
            'post'    => $post,
            'content' => $post->rendered(),
            'related' => Post::published()->where('id', '!=', $post->id)
                ->orderByRaw('category = ? desc', [$post->category])->take(3)->get(),
            'seo'     => Seo::meta([
                'title'       => Seo::title($post->title),
                'description' => $post->description,
                'image'       => \App\Support\Media::url($post->cover),
                'type'        => 'article',
            ]),
            'schema'  => [
                Seo::article($post),
                Seo::breadcrumb([['Beranda', route('home')], ['Blog', route('blog.index')], [$post->title, null]]),
            ],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\City;
use App\Models\Post;
use App\Models\Service;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $today = now()->toDateString();
        $url = fn ($loc, $lastmod, $priority) => compact('loc', 'lastmod', 'priority');

        $urls = collect([
            $url(route('home'), $today, '1.0'),
            $url(route('services.index'), $today, '0.8'),
            $url(route('cases.index'), $today, '0.7'),
            $url(route('blog.index'), $today, '0.7'),
            $url(route('about'), $today, '0.5'),
            $url(route('contact'), $today, '0.6'),
        ])
            ->merge(Service::active()->get()->map(fn ($s) => $url(route('services.show', $s->slug), $s->updated_at->toDateString(), '0.9')))
            ->merge(City::withPage()->get()->map(fn ($c) => $url(route('cities.show', $c->slug), $c->updated_at->toDateString(), '0.9')))
            ->merge(CaseStudy::active()->get()->map(fn ($c) => $url(route('cases.show', $c->slug), $c->updated_at->toDateString(), '0.7')))
            ->merge(Post::published()->get()->map(fn ($p) => $url(route('blog.show', $p->slug), $p->updated_at->toDateString(), '0.6')));

        return response()->view('sitemap', ['urls' => $urls])->header('Content-Type', 'application/xml');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public const CATEGORIES = [
        'simrs'         => 'SIMRS',
        'bpjs'          => 'BPJS',
        'satusehat'     => 'SATUSEHAT',
        'infrastruktur' => 'Infrastruktur',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at');
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? 'SIMRS';
    }

    /** Isi Markdown menjadi HTML, dengan id pada setiap <h2> untuk daftar isi. */
    public function rendered(): array
    {
        $html = Str::markdown((string) $this->body, ['html_input' => 'strip', 'allow_unsafe_links' => false]);
        $toc = [];

        $html = preg_replace_callback('/<h2>(.*?)<\/h2>/s', function ($m) use (&$toc) {
            $text = strip_tags($m[1]);
            $id = Str::slug($text);
            $toc[] = ['id' => $id, 'text' => $text];

            return '<h2 id="'.$id.'">'.$m[1].'</h2>';
        }, $html);

        return [
            'html' => $html,
            'toc' => $toc,
            'reading' => max(1, (int) ceil(str_word_count(strip_tags($html)) / 200)),
        ];
    }
}

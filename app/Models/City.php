<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'nearby' => 'array',
        'has_page' => 'boolean',
        'is_main' => 'boolean',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort')->orderBy('id');
    }

    public function scopeWithPage(Builder $query): Builder
    {
        return $query->where('has_page', true);
    }

    /** Paragraf isi halaman, dipisah baris kosong. */
    public function paragraphs(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R\s*\R/', (string) $this->body))));
    }
}

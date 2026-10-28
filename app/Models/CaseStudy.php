<?php

namespace App\Models;

use App\Models\Concerns\Ordered;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    use Ordered;

    protected $guarded = ['id'];

    protected $casts = [
        'facts' => 'array',
        'checks' => 'array',
        'sections' => 'array',
        'service_slugs' => 'array',
        'quote_approved' => 'boolean',
        'is_active' => 'boolean',
    ];

    /** Testimoni hanya tampil di website live bila sudah disetujui. */
    public function showQuote(): bool
    {
        return filled($this->quote) && ($this->quote_approved || app()->isLocal());
    }
}

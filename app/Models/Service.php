<?php

namespace App\Models;

use App\Models\Concerns\Ordered;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Ordered;

    protected $guarded = ['id'];

    protected $casts = [
        'tags' => 'array',
        'points' => 'array',
        'faqs' => 'array',
        'is_active' => 'boolean',
    ];

    public const GROUPS = [
        'software' => 'Software dan integrasi',
        'infra'    => 'Infrastruktur dan keamanan',
        'business' => 'Solusi bisnis',
    ];

    public const ICONS = [
        'pulse'   => 'Garis detak',
        'plus'    => 'Tanda plus',
        'monitor' => 'Monitor',
        'server'  => 'Server',
        'shield'  => 'Perisai',
        'clock'   => 'Jam',
        'building'=> 'Gedung',
    ];
}

<?php

namespace App\Models;

use App\Models\Concerns\Ordered;
use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    use Ordered;

    protected $guarded = ['id'];

    protected $casts = [
        'is_own' => 'boolean',
        'is_active' => 'boolean',
    ];
}

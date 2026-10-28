<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $counts = collect(config('admin.resources'))->map(fn ($r) => [
            'label' => $r['label'],
            'count' => $r['model']::count(),
        ]);

        return view('admin.dashboard', ['counts' => $counts]);
    }
}

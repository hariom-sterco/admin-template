<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ModuleEntry;

class MediaCoverageController extends Controller
{
    public function index()
    {
        $mediaCoverage = ModuleEntry::forModule(8, 'display_order', 'asc')->paginate(30)->through(fn($e) => $e->toCleanData());
        return view('dynamic.media-coverage', compact('mediaCoverage'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ModuleEntry;

class NewsLetterController extends Controller
{
    public function index()
    {
        $newsletter = ModuleEntry::forModule(9, 'display_order', 'asc')->paginate(30)->through(fn($e) => $e->toCleanData());
        return view('dynamic.newsletter', compact('newsletter'));
    }
}

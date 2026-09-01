<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ModuleEntry;
use Illuminate\Http\Request;

class LeadershipController extends Controller
{
    public function index()
    {
        $leadership = ModuleEntry::forModule(5, 'display_order', 'asc')->paginate(30)->through(fn($e) => $e->toCleanData());
        return view('dynamic.leadership', compact('leadership'));
    }
}

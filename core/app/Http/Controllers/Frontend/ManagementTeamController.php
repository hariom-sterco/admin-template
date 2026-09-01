<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ModuleEntry;

class ManagementTeamController extends Controller
{
    public function index()
    {
        $managementTeam = ModuleEntry::forModule(2, 'display_order', 'asc')->paginate(30)->through(fn($e) => $e->toCleanData());
        return view('dynamic.management-team', compact('managementTeam'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ModuleEntry;

class InvestorController extends Controller
{
    public function index()
    {
        $investor = ModuleEntry::forModule(10, 'display_order', 'asc')->get()->map(fn($e) => $e->toCleanData());
        return view('dynamic.investor', compact('investor'));
    }

    public function detail($slug)
    {
        $investor = ModuleEntry::where('slug', $slug)->where('module_id', 10)->firstOrFail();
        $allInvestor = ModuleEntry::forModule(10, 'display_order', 'asc')->get()->map(fn($e) => $e->toCleanData());
        $investorData = ModuleEntry::forModule(11, 'display_order', 'asc')->get()->map(fn($e) => $e->toCleanData())->filter(fn($e) => (string) ($e['investor-categories'] ?? '') === (string) $investor->id)->values();

        return view('dynamic.investor-detail', [
            'investor' => $investor,
            'allInvestor' => $allInvestor,
            'investorData' => $investorData,
        ]);
    }
}

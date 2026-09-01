<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ModuleEntry;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = ModuleEntry::forModule(7, 'display_order', 'asc')->paginate(30)->through(fn($e) => $e->toCleanData());
        return view('dynamic.blog', compact('blogs'));
    }

    public function detail($slug)
    {
        $blogDetail = ModuleEntry::where('slug', $slug)->where('module_id', 7)->firstOrFail();
        $blogDetail = $blogDetail->getDetailData($blogDetail->id);

        $relatedBlog = ModuleEntry::where('module_id', 7)
            ->where('slug', '!=', $slug)
            ->take(3)
            ->get()
            ->map(fn($item) => $item->toCleanData());

        return view('dynamic.blog-detail', [
            'blogDetail' => $blogDetail,
            'relatedBlog' => $relatedBlog,
        ]);
    }
}

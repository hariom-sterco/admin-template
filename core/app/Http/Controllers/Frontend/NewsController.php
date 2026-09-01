<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ModuleEntry;

class NewsController extends Controller
{
    public function index()
    {
        $news = ModuleEntry::forModule(1, 'date', 'desc')
            ->paginate(10)
            ->through(fn($e) => $e->toCleanData());

        $news->setCollection(
            $news->getCollection()->values()
        );

        return view('dynamic.news', [
            'news' => $news,
        ]);
    }

    public function detail($slug)
    {
        $newsDetail = ModuleEntry::where('slug', $slug)->where('module_id', 1)->firstOrFail();
        $newsDetail = $newsDetail->getDetailData($newsDetail->id);

        $relatedNews = ModuleEntry::where('module_id', 1)
            ->where('slug', '!=', $slug)
            ->take(3)
            ->get()
            ->map(fn($item) => $item->toCleanData());

        return view('dynamic.news-detail', [
            'newsDetail' => $newsDetail,
            'relatedNews' => $relatedNews,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ModuleEntry;
use App\Http\Controllers\Controller;

class GalleryFrontController extends Controller
{
    public function detail($slug)
    {
        $galleryDetail = ModuleEntry::where('slug', $slug)->where('module_id', 6)->firstOrFail();

        return view('dynamic.gallery-detail', [
            'galleryDetail' => $galleryDetail,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Redirection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedirectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-redirection')->only(['index', 'show']);
        $this->middleware('permission:create-redirection')->only(['create', 'store']);
        $this->middleware('permission:edit-redirection')->only(['edit', 'update']);
        $this->middleware('permission:delete-redirection')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        // $seo = SeoSetting::filter(['search' => $search])->orderBy('id', 'DESC')->paginate(10)->withQueryString()->through(function ($item) {
        //     return [
        //         'id' => $item->id,
        //         'url' => $item->url,
        //         'meta_title' => $item->meta_title,
        //         'meta_description' => $item->meta_description,
        //         'keywords' => $item->keywords ?? [],
        //         'search_terms' => $item->search_terms ?? [],
        //         'canonical_url' => $item->canonical_url,
        //         'og_title' => $item->og_title,
        //         'og_description' => $item->og_description,
        //         'og_image' => $item->og_image ? asset($item->og_image) : asset('assets/img/placeholder.png'),
        //         'og_type' => $item->og_type,
        //         'og_url' => $item->og_url,
        //         'created_at' => $item->created_at->format('M d, Y'),
        //         'updated_at' => $item->updated_at->format('M d, Y'),
        //     ];
        // });


        return Inertia::render('Redirection/Index', [
            'searchTerm' => $search ?? '',
            // 'seo' => $seo,
        ]);
    }

    public function create()
    {
        $previousUrl = url()->previous();
        if ($previousUrl && str_contains($previousUrl, '/redirection')) {
            if (
                !str_contains($previousUrl, '/create') &&
                !str_contains($previousUrl, '/edit')
            ) {
                session(['return_url.redirection' => $previousUrl]);
            }
        }

        return Inertia::render('Redirection/Create');
    }
}

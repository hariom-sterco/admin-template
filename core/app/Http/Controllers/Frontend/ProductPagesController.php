<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class ProductPagesController extends Controller
{
    public function cookware()
    {
        try {

            $page = Page::published()->bySlug('cookware')->firstOrFail();
            $viewData = $page->getModularPageData();

            return view('dynamic.cookware', [
                'page' => $page,
                'section' => $viewData,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function infra()
    {
        try {

            $page = Page::published()->bySlug('infra')->firstOrFail();
            $viewData = $page->getModularPageData();

            return view('dynamic.infra-solutions', [
                'page' => $page,
                'section' => $viewData,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function oem()
    {
        try {

            $page = Page::published()->bySlug('oem')->firstOrFail();
            $viewData = $page->getModularPageData();

            return view('dynamic.oem-manufacturing', [
                'page' => $page,
                'section' => $viewData,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function mobility()
    {
        try {

            $page = Page::published()->bySlug('mobility')->firstOrFail();
            $viewData = $page->getModularPageData();

            return view('dynamic.mobility-solutions', [
                'page' => $page,
                'section' => $viewData,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function homeSpaces()
    {
        try {

            $page = Page::published()->bySlug('home-spaces')->firstOrFail();
            $viewData = $page->getModularPageData();

            return view('dynamic.home-spaces', [
                'page' => $page,
                'section' => $viewData,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function homeware()
    {
        try {
            $page = Page::published()->bySlug('homeware')->firstOrFail();
            $viewData = $page->getModularPageData();

            return view('dynamic.homeware', [
                'page' => $page,
                'section' => $viewData,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

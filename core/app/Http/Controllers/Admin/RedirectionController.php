<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Redirection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

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

        $redirections = Redirection::filter(['search' => $search])->orderBy('id', 'DESC')->paginate(10)->withQueryString()->through(function ($item) {
            return [
                'id' => $item->id,
                'old_url' => $item->old_url,
                'new_url' => $item->new_url,
                'status' => $item->status,
                'created_at' => $item->created_at->format('M d, Y'),
                'updated_at' => $item->updated_at->format('M d, Y'),
            ];
        });

        return Inertia::render('Redirection/Index', [
            'searchTerm' => $search ?? '',
            'redirections' => $redirections,
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'old_url' => ['required', 'string', 'max:255', 'unique:redirections,old_url', 'different:new_url'],
            'new_url' => ['required', 'string', 'max:255', 'different:old_url'],
            'status' => ['required', 'in:0,1'],
            'search_terms' => 'nullable|array',
        ], [
            'old_url.different' => 'The old URL and new URL cannot be the same.',
            'new_url.different' => 'The old URL and new URL cannot be the same.',
        ]);

        Redirection::create($validated);

        $returnUrl = session()->pull('return_url.redirection', route('redirection.index'));
        return redirect()->to($returnUrl)->with('success', 'Redirection Added To Page!');
    }

    public function edit(Redirection $redirection)
    {
        $previousUrl = url()->previous();

        if ($previousUrl && str_contains($previousUrl, '/redirection')) {
            session(['return_url.redirection' => $previousUrl]);
        }

        return Inertia::render('Redirection/Edit', [
            'redirection' => $redirection,
        ]);
    }


    public function update(Request $request, Redirection $redirection)
    {
        $validated = $request->validate([
             'old_url' => ['required', 'string', 'max:255', Rule::unique('redirections', 'old_url')->ignore($redirection->id), 'different:new_url'],
            'new_url' => ['required', 'string', 'max:255', 'different:old_url'],
            'status' => ['required', 'in:0,1'],
            'search_terms' => 'nullable|array',
        ], [
            'old_url.different' => 'The old URL and new URL cannot be the same.',
            'new_url.different' => 'The old URL and new URL cannot be the same.',
        ]);


        $redirection->update($validated);

        $returnUrl = session()->pull('return_url.redirection', route('redirection.index'));
        return redirect()->to($returnUrl)->with('success', 'Redirection updated successfully!');
    }


     public function destroy(Redirection $redirection)
    {
        $redirection->delete();

        return back()->with('success', 'Redirection deleted successfully!');
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectEnquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectEnquiryAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-project-enquiry')->only('index');
        $this->middleware('permission:delete-project-enquiry')->only('destroy');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $projectEnquiries = ProjectEnquiry::filter(['search' => $search])
            ->latest('id')
            ->paginate(10)
            ->withQueryString()
            ->through(fn (ProjectEnquiry $item) => [
                'id' => $item->id,
                'full_name' => $item->full_name,
                'company_name' => $item->company_name,
                'business_email' => $item->business_email,
                'contact_number' => $item->contact_number,
                'project_requirement' => $item->project_requirement,
                'project_location' => $item->project_location,
                'message' => $item->message,
                'created_at' => $item->created_at,
            ]);

        return Inertia::render('ProjectEnquiry/Index', [
            'projectEnquiries' => $projectEnquiries,
            'searchTerm' => $search ?? '',
        ]);
    }

    public function destroy(ProjectEnquiry $projectEnquiry)
    {
        $projectEnquiry->delete();

        return back()->with('success', 'Project enquiry deleted successfully!');
    }
}

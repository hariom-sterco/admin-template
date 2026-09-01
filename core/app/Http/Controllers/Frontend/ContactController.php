<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use App\Models\Page;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $page = Page::published()->bySlug('contact-us')->firstOrFail();
        $viewData = $page->getModularPageData();
        return view('dynamic.contact-us', [
            'page' => $page,
            'section' => $viewData,
            'reasonToContact' => $this->reasonToContact(),
        ]);
    }

    protected function reasonToContact(): array
    {
        return [
            'sales' => 'Sales',
            'support' => 'Support',
            'general-enquiry' => 'General Enquiry',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'reason_to_contact' => ['required', 'string', 'in:' . implode(',', array_keys($this->reasonToContact()))],
            'message' => ['nullable', 'string', 'max:2000'],
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'company.required' => 'Please enter your company name.',
            'reason_to_contact.required' => 'Please select a reason for contacting us.',
            'g-recaptcha-response.required' => 'Please confirm you are not a robot.',
        ]);
        
        unset($validated['g-recaptcha-response']);
        $validated['ip_address'] = $request->ip();

        $inquiry = ContactForm::create($validated);

        return view('thank-you.thank-you');
    }
}

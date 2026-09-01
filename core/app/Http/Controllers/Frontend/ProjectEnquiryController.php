<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProjectEnquiry;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;

class ProjectEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'mobility');

        if (!in_array($type, ['infra', 'oem', 'mobility'])) {
            $type = 'mobility';
        }

        return view('dynamic.project-enquiry', [
            'type' => $type,
            'config' => $this->formConfig($type),
        ]);
    }

    protected function formConfig(string $type): array
    {
        return match ($type) {

            'infra' => [
                'title' => 'Enquiry Form',
                'heading' => "LET'S BUILD MODERN SPACES TOGETHER.",
                'description' => 'Whether you\'re planning a landmark installation, public infrastructure project, or customized stainless steel solution, our team is ready to bring your vision to life through precision engineering and dependable execution.',
                'field_label' => 'Project Requirement',
                'field_name' => 'project_requirement',
                'requirements' => [
                    'architectural-applications' => 'Architectural Applications',
                    'public-infrastructure-solutions' => 'Public Infrastructure Solutions',
                    'industrial-infrastructure-solutions' => 'Industrial Infrastructure Solutions',
                    'landmark-installations' => 'Landmark Installations',
                    'custom-stainless-steel-fabrications' => 'Custom Stainless Steel Fabrications',
                    'design-consultation' => 'Design Consultation',
                    'others' => 'Others',
                ],
                'location' => true,
                'cta' => 'START YOUR PROJECT',
            ],

            'oem' => [
                'title' => 'Enquiry Form',
                'heading' => '',
                'description' => '',
                'field_label' => 'OEM Requirement',
                'field_name' => 'project_requirement',
                'requirements' => [
                    'product-development' => 'Product Development',
                    'custom-fabrication' => 'Custom Fabrication',
                    'contract-manufacturing' => 'Contract Manufacturing',
                    'large-scale-manufacturing' => 'Large Scale Manufacturing',
                    'prototype-development' => 'Prototype Development',
                    'value-added-assemblies' => 'Value-Added Assemblies',
                    'others' => 'Others',
                ],
                'location' => false,
                'cta' => 'START YOUR OEM PROJECT',
            ],

            default => [
                'title' => 'Enquiry Form',
                'heading' => "LET'S ENGINEER MODERN MOBILITY TOGETHER.",
                'description' => 'Whether you\'re developing components for next-generation transit systems or seeking customized mobility solutions, our team is ready to support your requirements through precision engineering, certified quality, and dependable performance.',
                'field_label' => 'Mobility Requirement',
                'field_name' => 'project_requirement',
                'requirements' => [
                    'metro-coach-components' => 'Metro Coach Components',
                    'passenger-safety-solutions' => 'Passenger Safety Solutions',
                    'power-safety-systems' => 'Power & Safety Systems',
                    'cable-management-solutions' => 'Cable Management Solutions',
                    'custom-mobility-solutions' => 'Custom Mobility Solutions',
                    'transit-system-components' => 'Transit System Components',
                    'others' => 'Others',
                ],
                'location' => true,
                'cta' => 'DISCUSS YOUR MOBILITY REQUIREMENT',
            ],
        };
    }

    public function store(Request $request)
    {
        $type = $request->input('type', 'mobility');

        if (!in_array($type, ['infra', 'oem', 'mobility'])) {
            $type = 'mobility';
        }

        $config = $this->formConfig($type);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'business_email' => ['required', 'email', 'max:255'],
            'contact_number' => ['required', 'string', 'max:30'],

            'project_requirement' => [
                'required',
                'string',
                'in:' . implode(',', array_keys($config['requirements']))
            ],

            'project_location' => $config['location']
                ? ['required', 'string', 'max:255']
                : ['nullable', 'string', 'max:255'],

            'message' => ['nullable', 'string', 'max:2000'],

            'g-recaptcha-response' => [
                'required',
                new Recaptcha('project_enquiry')
            ],
        ], [
            'full_name.required' => 'Please enter your full name.',
            'company_name.required' => 'Please enter your company name.',
            'business_email.required' => 'Please enter your business email address.',
            'business_email.email' => 'Please enter a valid business email address.',
            'contact_number.required' => 'Please enter your contact number.',
            'project_requirement.required' => 'Please select a requirement.',
            'project_location.required' => 'Please enter your project location.',
            'g-recaptcha-response.required' => 'Please confirm you are not a robot.',
        ]);

        unset($validated['g-recaptcha-response']);

        $validated['enquiry_type'] = $type;
        $validated['ip_address'] = $request->ip();

        ProjectEnquiry::create($validated);

        return view('thank-you.thank-you');
    }
}
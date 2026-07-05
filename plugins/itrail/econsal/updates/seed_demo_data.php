<?php namespace ItRail\Econsal\Updates;

use ItRail\Econsal\Models\ContentBlock;
use ItRail\Econsal\Models\Country;
use ItRail\Econsal\Models\Service;
use ItRail\Econsal\Models\Slide;
use ItRail\Econsal\Models\SuccessStudent;
use ItRail\Econsal\Models\TeamMember;
use ItRail\Econsal\Models\VisaCategory;
use October\Rain\Database\Updates\Seeder;

class SeedDemoData extends Seeder
{
    public function run()
    {
        Slide::firstOrCreate(['title' => 'Study Abroad With Confidence'], [
            'subtitle' => 'Admissions, visa files, and student success',
            'description' => 'Plan your international education journey with expert counselling and end-to-end support.',
            'primary_button_text' => 'Book Appointment',
            'primary_button_link' => '/contact',
            'secondary_button_text' => 'Explore Services',
            'secondary_button_link' => '/student-services',
            'sort_order' => 1,
        ]);

        foreach (['Canada', 'United Kingdom', 'Australia', 'United States'] as $index => $name) {
            Country::firstOrCreate(['name' => $name], [
                'short_description' => 'Top-ranked institutions, flexible pathways, and strong student support.',
                'button_text' => 'Learn More',
                'button_link' => '/study-abroad',
                'sort_order' => $index + 1,
            ]);
        }

        foreach (['Student Visa', 'Visitor Visa', 'Dependent Visa'] as $index => $title) {
            VisaCategory::firstOrCreate(['title' => $title], [
                'short_description' => 'Professional guidance for document preparation, submission, and interview readiness.',
                'icon_class' => 'bi bi-passport',
                'button_text' => 'View Details',
                'button_link' => '/student-services',
                'sort_order' => $index + 1,
            ]);
        }

        foreach (['Career Counselling', 'University Selection', 'Admission Processing', 'Visa File Processing', 'Pre-departure Briefing'] as $index => $title) {
            Service::firstOrCreate(['title' => $title], [
                'short_description' => 'A focused service for a smoother international education journey.',
                'content' => '<p>Our counsellors provide practical, current, and student-focused support at every step.</p>',
                'icon_class' => 'bi bi-check-circle',
                'sort_order' => $index + 1,
            ]);
        }

        SuccessStudent::firstOrCreate(['student_name' => 'Demo Student'], [
            'country' => 'Canada',
            'university' => 'Sample University',
            'visa_type' => 'Student Visa',
            'testimonial' => 'The team helped me prepare a strong application and visa file.',
            'sort_order' => 1,
        ]);

        TeamMember::firstOrCreate(['name' => 'Senior Counsellor'], [
            'designation' => 'Education Consultant',
            'bio' => 'Experienced in admission guidance, visa documentation, and student counselling.',
            'sort_order' => 1,
        ]);

        $blocks = [
            'info-block' => ['title' => 'Your Trusted Study Abroad Partner', 'subtitle' => 'Expert guidance from counselling to arrival'],
            'required-documents' => ['title' => 'Required Documents', 'subtitle' => 'Prepare a complete file with confidence'],
            'home-cta' => ['title' => 'Ready to begin your study abroad journey?', 'subtitle' => 'Talk to an expert counsellor today.'],
            'about-intro' => ['title' => 'About Us', 'subtitle' => 'Professional education consultancy for ambitious students'],
            'student-services' => ['title' => 'Student Services', 'subtitle' => 'Complete support for admissions, scholarships, visas, and arrival'],
            'study-abroad' => ['title' => 'Study Abroad', 'subtitle' => 'Choose the right country, course, and pathway'],
            'contact-intro' => ['title' => 'Contact Us', 'subtitle' => 'We are ready to help with your questions'],
        ];

        foreach ($blocks as $code => $data) {
            ContentBlock::firstOrCreate(['code' => $code], $data + [
                'content' => '<p>Update this section from Econsal > Content Blocks.</p>',
                'button_text' => 'Contact Us',
                'button_link' => '/contact',
            ]);
        }
    }
}

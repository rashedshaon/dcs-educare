<?php namespace ItRail\Econsal\Updates;

use ItRail\Econsal\Models\SuccessStudent;
use ItRail\Econsal\Models\TeamMember;
use October\Rain\Database\Updates\Migration;

class PopulateTeamAndSuccessStudents extends Migration
{
    public function up()
    {
        $this->seedTeamMembers();
        $this->seedSuccessStudents();
    }

    public function down()
    {
        // Seed content is intentionally preserved on rollback.
    }

    private function seedTeamMembers()
    {
        $members = [
            ['name' => 'MD Rezaul Karim', 'designation' => 'Chief Executive Officer'],
            ['name' => 'Aeysha Siddika', 'designation' => 'Director- International Communication'],
            ['name' => 'Mahanaz Afrin', 'designation' => 'Manager'],
            ['name' => 'Billal Hossain', 'designation' => 'Accounts Manager'],
            ['name' => 'Jannatul Nayim', 'designation' => 'Business Development Officer'],
            ['name' => 'Md Jakiul Hassan Riad', 'designation' => 'Senior Counselor'],
            ['name' => 'Tofazzol Mia', 'designation' => 'Marketing Executive'],
            ['name' => 'Rubel Rana', 'designation' => 'Marketing head'],
            ['name' => 'Shah Makhdum Islam Maktum', 'designation' => 'Counselor & Admission Officer'],
            ['name' => 'Shoshi Mondal Sunny', 'designation' => 'Digital Marketing'],
            ['name' => 'Rimpa', 'designation' => 'Marketing Executive'],
            ['name' => 'Sumaya Siddique', 'designation' => 'Executive Counselor'],
            ['name' => 'Md. Shamim Ahmed', 'designation' => 'Sr. Marketing Executive'],
        ];

        foreach ($members as $index => $member) {
            TeamMember::updateOrCreate(['name' => $member['name']], [
                'designation' => $member['designation'],
                'bio' => null,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedSuccessStudents()
    {
        $students = [
            [
                'student_name' => 'Nusrat Jahan',
                'country' => 'Canada',
                'university' => 'Seneca Polytechnic',
                'visa_type' => 'Student Visa',
                'testimonial' => 'My admission and visa documentation process became much easier with step-by-step counselling support.',
            ],
            [
                'student_name' => 'Tanvir Ahmed',
                'country' => 'Australia',
                'university' => 'Charles Darwin University',
                'visa_type' => 'Student Visa',
                'testimonial' => 'The counsellors helped me choose the right course, prepare financial papers, and submit my visa file confidently.',
            ],
            [
                'student_name' => 'Sadia Islam',
                'country' => 'UK',
                'university' => 'University of Hertfordshire',
                'visa_type' => 'Student Visa',
                'testimonial' => 'I received clear guidance for my SOP, CAS documents, and embassy checklist from the beginning.',
            ],
            [
                'student_name' => 'Mehedi Hasan',
                'country' => 'Denmark',
                'university' => 'University College Absalon',
                'visa_type' => 'Student Visa',
                'testimonial' => 'From course selection to document review, the full process was organized and transparent.',
            ],
            [
                'student_name' => 'Farhana Akter',
                'country' => 'Sweden',
                'university' => 'Linnaeus University',
                'visa_type' => 'Residence Permit for Studies',
                'testimonial' => 'The team guided me through admission requirements, bank documents, and residence permit preparation.',
            ],
            [
                'student_name' => 'Rakibul Islam',
                'country' => 'Malaysia',
                'university' => 'Asia Pacific University',
                'visa_type' => 'Student Pass',
                'testimonial' => 'I got practical advice on university options, offer letter steps, and visa processing timelines.',
            ],
        ];

        foreach ($students as $index => $student) {
            SuccessStudent::updateOrCreate(['student_name' => $student['student_name']], $student + [
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}

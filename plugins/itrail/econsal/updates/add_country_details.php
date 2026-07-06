<?php namespace ItRail\Econsal\Updates;

use Schema;
use ItRail\Econsal\Models\Country;
use October\Rain\Database\Updates\Migration;

class AddCountryDetails extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('itrail_econsal_countries', 'slug')) {
            Schema::table('itrail_econsal_countries', function ($table) {
                $table->string('slug')->nullable()->after('name');
            });
        }

        if (!Schema::hasColumn('itrail_econsal_countries', 'content')) {
            Schema::table('itrail_econsal_countries', function ($table) {
                $table->mediumText('content')->nullable()->after('short_description');
            });
        }

        $this->seedCountries();
    }

    public function down()
    {
        if (Schema::hasColumn('itrail_econsal_countries', 'content')) {
            Schema::table('itrail_econsal_countries', function ($table) {
                $table->dropColumn('content');
            });
        }

        if (Schema::hasColumn('itrail_econsal_countries', 'slug')) {
            Schema::table('itrail_econsal_countries', function ($table) {
                $table->dropColumn('slug');
            });
        }
    }

    private function seedCountries()
    {
        $countries = [
            ['name' => 'New Zealand', 'slug' => 'new-zealand', 'sort_order' => 1],
            ['name' => 'Denmark', 'slug' => 'denmark', 'sort_order' => 2],
            ['name' => 'Sweden', 'slug' => 'sweden', 'sort_order' => 3],
            ['name' => 'Australia', 'slug' => 'australia', 'sort_order' => 4],
            ['name' => 'Canada', 'slug' => 'canada', 'sort_order' => 5],
            ['name' => 'USA', 'slug' => 'usa', 'sort_order' => 6, 'aliases' => ['United States']],
            ['name' => 'UK', 'slug' => 'uk', 'sort_order' => 7, 'aliases' => ['United Kingdom']],
            ['name' => 'Malaysia', 'slug' => 'malaysia', 'sort_order' => 8],
        ];

        foreach ($countries as $countryData) {
            $country = Country::where('slug', $countryData['slug'])
                ->orWhere('name', $countryData['name']);

            foreach ($countryData['aliases'] ?? [] as $alias) {
                $country->orWhere('name', $alias);
            }

            $country = $country->first() ?: new Country;
            $country->name = $countryData['name'];
            $country->slug = $countryData['slug'];
            $country->short_description = $this->shortDescription($countryData['name']);
            $country->content = $this->description($countryData['name']);
            $country->sort_order = $countryData['sort_order'];
            $country->is_active = true;
            $country->button_text = null;
            $country->button_link = null;
            $country->save();
        }
    }

    private function shortDescription(string $country): string
    {
        return "Study in {$country} with guidance on living costs, family options, work rights, and visa documents.";
    }

    private function description(string $country): string
    {
        return '<p>' . $country . ' is a popular study destination for international students who want quality education, practical learning, and a clear pathway for personal growth. Students should plan early for tuition fees, accommodation, food, transport, health insurance, and everyday living expenses so their study journey remains stable and comfortable.</p>'
            . '<h3>Living and Food</h3><p>Most students choose university halls, shared apartments, homestays, or private rentals depending on budget and location. Cooking at home, using student discounts, and living close to campus can reduce monthly costs. New students should arrange temporary accommodation before arrival and confirm permanent housing after checking commute time, safety, and contract terms.</p>'
            . '<h3>Taking Family Members</h3><p>Family options depend on visa category, course level, sponsor rules, and current immigration policy. In many cases, spouses or children may need separate applications, financial evidence, health cover, and relationship documents. Students should check eligibility before applying and prepare a realistic budget for family housing, schooling, medical insurance, and daily expenses.</p>'
            . '<h3>Work While Studying</h3><p>International students may be allowed to work part time during study and full time during official breaks, subject to visa conditions. Common student jobs include hospitality, retail, campus support, customer service, and entry-level office work. Work should support the student budget, but academic progress, attendance, and visa compliance must remain the first priority.</p>'
            . '<h3>Required Documents</h3><p>A strong application usually includes passport, academic certificates and transcripts, English language test results if required, statement of purpose, CV, recommendation letters, offer letter, financial documents, sponsor papers, identity documents, medical or police clearance where applicable, and visa forms. Requirements can change by institution and immigration authority, so students should prepare documents carefully and verify the latest checklist before submission.</p>';
    }
}

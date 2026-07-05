<?php namespace ItRail\Econsal\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class AddSlideTextColors extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('itrail_econsal_slides', 'title_color')) {
            Schema::table('itrail_econsal_slides', function (Blueprint $table) {
                $table->string('title_color')->nullable()->after('description');
            });
        }

        if (!Schema::hasColumn('itrail_econsal_slides', 'subtitle_color')) {
            Schema::table('itrail_econsal_slides', function (Blueprint $table) {
                $table->string('subtitle_color')->nullable()->after('title_color');
            });
        }

        if (!Schema::hasColumn('itrail_econsal_slides', 'description_color')) {
            Schema::table('itrail_econsal_slides', function (Blueprint $table) {
                $table->string('description_color')->nullable()->after('subtitle_color');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('itrail_econsal_slides', 'description_color')) {
            Schema::table('itrail_econsal_slides', function (Blueprint $table) {
                $table->dropColumn('description_color');
            });
        }

        if (Schema::hasColumn('itrail_econsal_slides', 'subtitle_color')) {
            Schema::table('itrail_econsal_slides', function (Blueprint $table) {
                $table->dropColumn('subtitle_color');
            });
        }

        if (Schema::hasColumn('itrail_econsal_slides', 'title_color')) {
            Schema::table('itrail_econsal_slides', function (Blueprint $table) {
                $table->dropColumn('title_color');
            });
        }
    }
}

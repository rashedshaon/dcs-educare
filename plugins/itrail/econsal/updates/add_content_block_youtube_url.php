<?php namespace ItRail\Econsal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddContentBlockYoutubeUrl extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('itrail_econsal_content_blocks', 'youtube_url')) {
            Schema::table('itrail_econsal_content_blocks', function ($table) {
                $table->string('youtube_url')->nullable()->after('content');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('itrail_econsal_content_blocks', 'youtube_url')) {
            Schema::table('itrail_econsal_content_blocks', function ($table) {
                $table->dropColumn('youtube_url');
            });
        }
    }
}

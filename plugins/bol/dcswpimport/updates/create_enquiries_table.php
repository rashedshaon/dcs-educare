<?php namespace Bol\DcsWpImport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateEnquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('bol_dcswpimport_enquiries', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 120);
            $table->string('email', 190)->nullable();
            $table->string('phone', 40);
            $table->string('service', 190)->nullable();
            $table->text('message')->nullable();
            $table->string('ip_address', 64)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('status', 30)->default('new')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bol_dcswpimport_enquiries');
    }
}

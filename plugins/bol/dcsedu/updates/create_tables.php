<?php namespace Bol\Dcsedu\Updates;
use Schema; use October\Rain\Database\Updates\Migration;
class CreateTables extends Migration{
 public function up(){
  if(!Schema::hasTable('bol_dcsedu_posts')) Schema::create('bol_dcsedu_posts',function($t){$t->increments('id');$t->string('title');$t->string('slug')->unique();$t->text('excerpt')->nullable();$t->longText('content')->nullable();$t->string('featured_image')->nullable();$t->boolean('is_published')->default(1);$t->timestamp('published_at')->nullable();$t->timestamps();});
  if(!Schema::hasTable('bol_dcsedu_contact_leads')) Schema::create('bol_dcsedu_contact_leads',function($t){$t->increments('id');$t->string('name')->nullable();$t->string('email')->nullable();$t->string('phone')->nullable();$t->string('subject')->nullable();$t->text('message')->nullable();$t->string('ip_address')->nullable();$t->timestamps();});
 }
 public function down(){Schema::dropIfExists('bol_dcsedu_contact_leads');Schema::dropIfExists('bol_dcsedu_posts');}
}

<?php namespace Bol\Dcsedu\Models;
use Model;
class Post extends Model{public $table='bol_dcsedu_posts';protected $fillable=['title','slug','excerpt','content','featured_image','is_published','published_at'];protected $dates=['published_at','created_at','updated_at'];}

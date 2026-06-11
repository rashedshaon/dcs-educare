<?php namespace Bol\Dcsedu\Components;
use Cms\Classes\ComponentBase; use Bol\Dcsedu\Models\Post; use Cms\Classes\Controller;
class BlogPost extends ComponentBase{public function componentDetails(){return ['name'=>'DCS Blog Post','description'=>'Shows post'];} public function defineProperties(){return ['slug'=>['title'=>'Slug','default'=>'{{ :slug }}']];} public function onRun(){$post=Post::where('slug',$this->property('slug'))->where('is_published',1)->first(); if(!$post) return Controller::getController()->run('404'); $this->page['post']=$post;}}

<?php namespace Bol\Dcsedu\Components;
use Cms\Classes\ComponentBase; use Bol\Dcsedu\Models\Post;
class BlogList extends ComponentBase{public function componentDetails(){return ['name'=>'DCS Blog List','description'=>'Shows posts'];} public function defineProperties(){return ['perPage'=>['title'=>'Per Page','default'=>8]];} public function onRun(){$this->page['posts']=Post::where('is_published',1)->orderBy('published_at','desc')->paginate((int)$this->property('perPage',8));}}

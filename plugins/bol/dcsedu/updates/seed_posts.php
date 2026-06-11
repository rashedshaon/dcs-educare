<?php namespace Bol\Dcsedu\Updates;
use Seeder; use Bol\Dcsedu\Models\Post; use Carbon\Carbon;
class SeedPosts extends Seeder{
 public function run(){
  $items=[
   ['slug'=>'study-in-denmark','title'=>'Study in Denmark','excerpt'=>'ডেনমার্ক একটি উন্নত দেশ, যার বিশ্ববিদ্যালয়গুলো বিশ্বমানের শিক্ষা প্রদান করে।','content'=>'<p>ডেনমার্ক একটি উন্নত দেশ, যার বিশ্ববিদ্যালয়গুলো বিশ্বমানের শিক্ষা প্রদান করে।</p>','featured_image'=>'https://dcsedu.org/wp-content/uploads/2025/02/Study-Canada-1.png2_.png'],
   ['slug'=>'study-in-australia','title'=>'Study in Australia','excerpt'=>'উত্তর আমেরিকার দেশ অস্ট্রেলিয়া। উচ্চ শিক্ষার এক চমৎকার স্থান।','content'=>'<p>উত্তর আমেরিকার দেশ অস্ট্রেলিয়া। উচ্চ শিক্ষার এক চমৎকার স্থান।</p>','featured_image'=>'https://dcsedu.org/wp-content/uploads/2025/02/Study-Canada-1.png1_.png'],
   ['slug'=>'recent-updates-of-visa-and-immagration','title'=>'Higher Study In The UK','excerpt'=>'সুন্দর শহর, আশ্চর্যজনক মানুষ, আন্তর্জাতিক শিক্ষার্থীদের সাথে দেখা করার সুযোগ।','content'=>'<p>সুন্দর শহর, আশ্চর্যজনক মানুষ, আন্তর্জাতিক শিক্ষার্থীদের সাথে দেখা করার সুযোগ।</p>','featured_image'=>'https://dcsedu.org/wp-content/uploads/2022/09/Study-Canada-1.png3-1.png']
  ];
  foreach($items as $i){Post::updateOrCreate(['slug'=>$i['slug']],['title'=>$i['title'],'excerpt'=>$i['excerpt'],'content'=>$i['content'],'featured_image'=>$i['featured_image'],'is_published'=>1,'published_at'=>Carbon::now()]);}
 }
}

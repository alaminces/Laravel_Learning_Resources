<?php 

/*************************************
 * Laravel Log 
***************************************/

/* 
Request & Respons এর মাঝে যখন কোনো ঘটনা ঘটে বা কোনো ধরনের ইরর ঘটলে সেটাকে History করে রাখার জন্য কিছু বিল্ট ইন ফাংশন বা ফিচার আছে। 
যেমন Restriction Purpose, Monitoring Purpose, Debugging Purpose etc.
Log Report দেখে আমরা Decision নিতে পারি আমাদের Application এর কোন কোন জায়গায় ইরর হইছে।

Log এর বিল্ট ইন ফিচার ব্যবহার করার ফলে তার বিস্তারিত সব কিছু storage/log/laravel.log তে পাওয়া যায়।

=> Log এর বিল্ট-ইন ফিচার সমূহ :

Log::emergency($message);
Log::alert($message);
Log::critical($message);
Log::error($message);
Log::warning($message);
Log::notice($message);
Log::info($message);
Log::debug($message);

*/

// For Example 
Route::get('/test', function() {
  $sum = 10 + 20;
  Log::info($sum);
  Log::emergency($sum);
  Log::warning($sum);
  return "Log Example";
});
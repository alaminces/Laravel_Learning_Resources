<?php 

/*************************************
 * Laravel Log 
***************************************/

/* 
Request & Respons এর মাঝে যখন কোনো ঘটনা ঘটে বা কোনো ধরনের ইরর ঘটলে সেটাকে History করে রাখার জন্য কিছু বিল্ট ইন ফাংশন বা ফিচার আছে। 
যেমন Restriction Purpose, Monitoring Purpose, Debugging Purpose etc.
Log Report দেখে আমরা Decision নিতে পারি আমাদের Application এর কোন কোন জায়গায় ইরর হইছে।

=> Log এর বিল্ট-ইন ফিচার সমূহ :
Log::info(); 
Log::emergency()
Log::alert()
Log::critical()
Log::error()
Log::warning()
Log::notice()
Log::debug()

*/

// For Example 
Route::get('/test', function() {
  $sum = 10 + 20;
  Log::info($sum);
  Log::emergency($sum);
  Log::warning($sum);
  return "Log Example";
});
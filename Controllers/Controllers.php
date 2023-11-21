<?php 

/*
	Basic Controllers 
	Controller একটি Class বা PHP File যার মাধ্যমে বিভিন্ন ধরনের Logic Implement করা যায়।
	# To create a controller write in terminal
	>> php artisan make:controller DemoController
	>> php artisan r:l (route:list)
	
	After creating controller, DemoController is saved inside app\Http\Controllers named DemoController.php
	# Controller controls all incoming HTTP requests
*/

//Controller Connect with Route 
# in web.php 
#-------------------------------------------------------------------------
use App\Http\Controllers\DemoController;
Route::get('/urlName', [DemoController::class,'methodName']);

# in DemoController.php 
#-------------------------------------------------------------------------
use Illuminate\Http\Request;
class DemoController extends Controller {
	public function methodName(Request $request):string {
		return response('Everything is fine',200);
	}
}



// Single Action Controllers 
/*
	একটি ঘটনা ঘটে যে Controller  এর তাকে আমরা বলি Single Action Controller ।
	শুধুমাত্র একটি Request কে ম্যানেজ করার জন্য এটি ব্যবহার করা হয়।
	Single Action Controller এর মধ্যে শুধুমাত্র একটাই __invoke নামে মেথড থাকে।
	To create a single action controller the following below
	>> php artisan make:controller SingleActionController --invokable
*/
#-------------------------------------------------------------------------

// in SingleActionController.php 
public function __invoke(Request $request):string {
	return "I'm single action controller";
}

// in web.php 
use App\Http\Controllers\SingleActionController;
Route::get('/singleAction', SingleActionController::class);



/*-------------------------------------------------------------------------
// Resource Controller 
CRUD Operation করার জন্য যে মেথডগুলোর প্রয়োজন হয় সেগুলো বাই ডিফল্ট Resource Controller এ দেয়া থাকে।

# Resource Controller Creating Command:
php artisan make:controller UserController --resource 
php artisan make:controller UserController -r 

# Create Controller With Directory
php artisan make:controller User/UserController --resource 

# Methods of Resource Controller
*/
function index() { return "From index"; }
function create() { return "From create"; }
function store(Request $request) { return "From store"; }
function show(string $id) { return "From show"; }
function edit(string $id) { return "From edit"; }
function update(Request $request, string $id) { return "From update"; }
function destroy(string $id) { return "From destroy"; }
/*
# For a Resource Controller Route should be only one 
Route::resource('users', UserController::class);
-------------------------------------------------------------------------*/

Route::resource('users', UserController::class);
/*
	GET() for index  -> /users 
	GET() for create -> /users/create 
	GET() for show -> /users/{user} 
	GET() for edit -> /users/{id}/edit 
	POST() for store -> /users 
	PUT/PATCH() for update -> /users/{id} 
	DELETE() for destroy -> /users/{id} 
	
*/

# Using Resources Method 
// You may even register many resource controllers at once by passing an array to the resources method:

Route::resources([
    'photos' => PhotoController::class,
    'posts' => PostController::class,
]);


# Partial Resource Routes
/*-----------------------------------------------------------------------------*/
# access only method / methods of resource controller
Route::resource('/photos', PhotosController::class)->only('index');
Route::resource('/photos', PhotosController::class)->only(['index','store']);

# access some methods from resource controller 
Route::resource('/photos', PhotosController::class)->except(['edit','destroy','update']);






/*
	Laravel অথবা যেকোনো MVC Framework এ Controller এর কাজ হচ্ছে View এবং Model কে Control বা নিয়ন্ত্রণ করা বা Model এবং View এর সাথে সমন্বয় সাধন করা।
	
	MVC ভিত্তিক যেকোনো software অথবা Web Application এর সমস্ত Business Logic রাখা হয় Controller এ । User কোন কিছুর জন্য request করলে সেটা প্রথমে যায় Controller এ । Request এর Response যদি Database এর কোন Data প্রয়োজন হয় তবে Controller তা Model এর মাধ্যমে এনে user এর প্রয়োজন অনুযায়ী Process করে View তে পাঠায়। এরপর User তার Request এর Response দেখতে পায়।
	
	# Single Action/invokable controller
	আপনি যদি একটা Controller কে শুধু মাত্র একটা নির্দিষ্ট কাজের জন্য ব্যবহার করতে চান , তাহলে আপনি single action controller বা invokable controller ব্যবহার করতে পারেন। এক্ষেত্রে আপনাকে route এ আলাদা করে class method এর নাম বলে দেওয়া লাগবেনা।
	
	# Resource Controllers
	লারাভেল ফ্রেমওয়ার্ক এ আপনি আপনার অ্যাপ্লিকেশানের প্রতিটি ভিন্ন ইলোকুয়েন্ট মডেলকে এক একটি “resource” হিসেবে ব্যবহার করতে পারেন, এতে আপনার অ্যাপ্লিকেশানের রিসোর্সের প্রতিটি কাজের জন্য আলাদা করে route action ডিক্লেয়ার করার দরকার হবেনা । আপনি সবগুলো অ্যাকশন এর জন্য শুধু মাত্র একটা resource route ঘোষণা করলেই যথেষ্ট। উদাহরণস্বরূপ, ধরুন আপনার অ্যাপ্লিকেশনটিতে একটি Product মডেল আছে,আপনি চাইলে এর create, read, update, এবং delete (“CRUD”) এর কাজগুলো করতে শুধু মাত্র একটা resource route ঘোষণা করতে পারেন। । তবে এর জন্য আপনাকে প্রথমে একটা resource Controller তৈরি করতে হবে।
	
	# By Default Created method in Resource Controller 
	index() এই মেথড দিয়ে আমরা সবগুলো প্রোডাক্ট টেবুলাইজ আকারে দেখাবো।
	create() এইটা দিয়ে মূলতঃ আমরা নতুন প্রোডাক্ট তৈরির ফর্মটি শো করব। 
	store() এইটা দিয়ে আমরা মূলতঃ ডাটাবেসে প্রোডাক্ট ইনফরমেশন সংরক্ষণ করব।
	show() একটা নির্দিষ্ট প্রোডাক্টের বিস্তারিত প্রদর্শনের জন্য এই মেথড ব্যবহার করব।
	edit() এই মেথড দিয়ে একটা নির্দিষ্ট প্রোডাক্ট এডিট করার সুবিধা যুক্ত করব। বা Edit ফর্ম টি এই মেথড দিয়ে আমরা প্রদর্শন করব।
	update() এই মেথড দিয়ে একটা নির্দিষ্ট প্রোডাক্টের ডাটাবেস আপডেটের কাজটি করব।
	destroy() এই মেথড দিয়ে একটা নির্দিষ্ট প্রোডাক্ট কে ডিলিট এর কাজটি করব।

*/



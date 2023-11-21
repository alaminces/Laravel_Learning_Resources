<?php 

/*
web.php
------------
*/
use App\Http\Controllers\DemoController;
use App\Http\Middleware\DemoMiddleware;

// *************************************************************************
// Basic Middleware create 
Route::get( '/user/{role}', [DemoController::class,'demo'] )->middleware( [DemoMiddleware::class] );
Route::get( '/err', [DemoController::class,'getErr'] );

// Middleware without group create : 
Route::get( '/mobile/{price}', [DemoController::class,'product1'] )->middleware( [DemoMiddleware::class] );
Route::get( '/computer/{price}', [DemoController::class,'product2'] )->middleware( [DemoMiddleware::class] );
Route::get( '/laptop/{price}', [DemoController::class,'product3'] )->middleware( [DemoMiddleware::class] );

// *************************************************************************
// Middleware with group route with kernel.php
Route::middleware('make')->group( function() {
     Route::get( '/mobile/{price}', [DemoController::class,'product1'] );
     Route::get( '/computer/{price}', [DemoController::class,'product2'] );
     Route::get( '/laptop/{price}', [DemoController::class,'product3'] );
} );

// Note: got to kernel.php -> middlewareAliases ->  write in 1st item 
'make' => \App\Http\Middleware\DemoMiddleware::class

// *************************************************************************
// >>>> Middleware apply for entire/whole application

Route::get('/sum/{n1}/{n2}', [DemoController::class,'sum']);
Route::get('/sub/{n1}/{n2}', [DemoController::class,'sub']);

/*
  Note: without use this : use App\Http\Middleware\DemoMiddleware;
  Go to kernel.php -> middlewareGroups -> web | api -> write in 1st item
  \App\Http\Middleware\DemoMiddleware::class
*/



// *************************************************************************
/*
DemoMiddleware.php
--------------------------------
*/
public function handle( Request $request, Closure $next ) : Response {
  // return $next( $request );

     if ( $request->header('role') == 'admin'  ) {
           return $next( $request );
    }else {
          return response()->json( 'unauthorized', 401 );
         // return redirect( '/err' );
    }

}

// *************************************************************************
/*
DemoController.php
------------------------------
*/
function demo():string {
   return "Process complete";
}

function getErr() {
   return "Redirected to this method";
}
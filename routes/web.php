<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
   // return view('welcome');
//});

Route::get('/', [ProductController::class, 'index']);  
//Route::get('create', [ProductController::class, 'create'])->name('create');
//Route::get('create', 'ProductController@create');
//Route::post('/product', 'ProductController@store');

Route::get('cart', [ProductController::class, 'cart'])->name('cart');

Route::get('add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add.to.cart');

Route::patch('update-cart', [ProductController::class, 'update'])->name('update.cart');

Route::delete('remove-from-cart', [ProductController::class, 'remove'])->name('remove.from.cart');

Route::get('/produce-to-kafka', function () {
   \Artisan::call('kafka:produce');
   return 'Message sent to Kafka';
});

Route::get('/newmsg', function () {
    // Define the path to your NewConsumer.php script
    $scriptPath = base_path('app/Helper/NewConsumer.php');

    // Execute the script using the PHP process
    $output = shell_exec("php {$scriptPath}");

    // Return the script's output as a response
    return response($output);
});


Route::get('/testconsumer', function () {
    // Define the path to your NewConsumer.php script
    $scriptPath = base_path('app/Helper/Testconsumer.php');

    // Execute the script using the PHP process
    $output = shell_exec("php {$scriptPath}");

    // Return the script's output as a response
    return response($output);
});



Route::get('/newproducer', function () {
    // Define the path to your NewProducer.php script
    $scriptPath = base_path('app/Helper/NewProducer.php');

    // Execute the script using the PHP process
    $output = shell_exec("php {$scriptPath}");

    // Return the script's output as a response
    return response($output);
});







Route::get('/consume-messages', function () {
    // Define the path to your ConsumeMessages.php script
    $scriptPath = base_path('app/Helper/ConsumeMessages.php');

    // Execute the script using the PHP process
    $output = shell_exec("php {$scriptPath}");

    // Return the script's output as a response
    return response($output);
});

Route::get('/run-migration',function(){
Artisan::call('optimize:clear');
Artisan::call('migrate:fresh --sedd');
return"Migration sucessfully executed";

});
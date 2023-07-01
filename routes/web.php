<?php

use App\Enums\Role;
use App\Http\Controllers\UserController;
use App\Models\Plan;
use App\Models\OrdenPlan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProcessPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $plans = Plan::get();
    return view('welcome',compact("plans"));
});

Route::get('/dashboard', function () {
    $fotografo = Role::Fotografo;
    $organizacion = Role::Organizacion;
    $plans = Plan::with('beneficios')->where('type',auth()->user()->role)->get();
    $ordenes = OrdenPlan::with('plan')->where('user_id',auth()->user()->id)->paginate(9);
    return view('dashboard',compact('fotografo','organizacion','ordenes','plans'));
})->middleware(['auth'])->name('dashboard');

Route::get('/users', [UserController::class, 'listAll'])->middleware(['auth'])->name('users.listAll');

Route::get('/users/banned', [UserController::class, 'bannedListAll'])->middleware(['auth'])->name('users.banned.listAll');
Route::post('/users/banned/{user}', [UserController::class, 'bannedListAdd'])->middleware(['auth'])->name('users.banned.listAdd');

Route::get('/users/notbanned', [UserController::class, 'notBannedListAll'])->middleware(['auth'])->name('users.notbanned.listAll');
Route::post('/users/notbanned/{user}', [UserController::class, 'notBannedListAdd'])->middleware(['auth'])->name('users.notbanned.listAdd');


Route::get('/process-payment/{plan}', [ProcessPaymentController::class, 'index']);


require __DIR__.'/auth.php';

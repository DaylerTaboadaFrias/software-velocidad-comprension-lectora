<?php

use App\Enums\Role;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\UserController;
use App\Models\Plan;
use App\Models\OrdenPlan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\CategoryController;
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
    return view('welcome', compact("plans"));
});

Route::get('/dashboard', function () {
    $fotografo = Role::Cliente;
    $organizacion = Role::Organizacion;
    $plans = Plan::with('beneficios')->where('type', auth()->user()->role)->get();
    $ordenes = OrdenPlan::with('plan')->where('user_id', auth()->user()->id)->paginate(9);
    return view('dashboard', compact('fotografo', 'organizacion', 'ordenes', 'plans'));
})->middleware(['auth'])->name('dashboard');

Route::get('/organizacion/eventos', [EventController::class, 'listarOrganizacion'])->name('organizacion.eventos');
Route::get('/organizacion/eventos/crear', [EventController::class, 'crear'])->name('crear.evento');
Route::post('/organizacion/eventos/store', [EventController::class, 'store'])->name('evento.store');
Route::delete('/organizacion/eventos/destroy/{evento}', [EventController::class, 'destroy'])->name('evento.destroy');
Route::get('/organizacion/eventos/edit/{evento}', [EventController::class, 'edit'])->name('evento.edit');
Route::put('/organizacion/eventos/update/{evento}', [EventController::class, 'update'])->name('evento.update');

Route::group(['prefix' => 'category'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/', [CategoryController::class, 'store'])->name('category.store');
    Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('{id}/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index'])->name('level.index');
    Route::get('/create', [LevelController::class, 'create'])->name('level.create');
    Route::post('/', [LevelController::class, 'store'])->name('level.store');
    Route::get('{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
    Route::put('/{id}', [LevelController::class, 'update'])->name('level.update');
    Route::get('{id}/destroy', [LevelController::class, 'destroy'])->name('level.destroy');
});

Route::resource('ejercicios', EjercicioController::class);

Route::group([
    'prefix' => 'users',
    'middleware' => ['auth', 'check.admin'],
    'controller' => UserController::class,
], function () {
    Route::get('/', 'listAll')->name('users.listAll');
    Route::get('/banned', 'bannedListAll')->name('users.banned.listAll');
    Route::post('/banned/{user}', 'bannedListAdd')->name('users.banned.listAdd');
    Route::get('/notbanned', 'notBannedListAll')->name('users.notbanned.listAll');
    Route::post('/notbanned/{user}', 'notBannedListAdd')->name('users.notbanned.listAdd');
});

Route::get('/process-payment/{plan}', [ProcessPaymentController::class, 'index']);


require __DIR__ . '/auth.php';
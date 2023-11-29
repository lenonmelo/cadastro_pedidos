<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

//Rotas de login e logouts
Route::get('login', [AuthUserController::class, 'index'])->name('login');
Route::post('login', [AuthUserController::class, 'login'])->name('login');
Route::post('logout', [AuthUserController::class, 'logout'])->name('logout');

//Rotas para o CRUD de usuarios
Route::resource('users', UserController::class);

//Rotas para o CRUD de clientes
Route::resource('clientes', ClientesController::class);

//Rota para mostrar a imagem original.
Route::get('/pedidos/mostrarImagem', [PedidosController::class, 'showImage'])->name('pedidos.mostrarImagem');

//Rota para exportar os pedidos
Route::get('/pedidos/export', [PedidosController::class, 'export'])->name('pedidos.exportar');


//Rotas para o CRUD de pedidos
Route::resource('pedidos', PedidosController::class);

//Rota para exibição de imagens
Route::get('images/{filename}', function ($filename) {
    $path = storage_path("app/images/$filename");

    if (!Storage::exists("images/$filename") || !file_exists($path)) {
        abort(404);
    }

    $file = Storage::get("images/$filename");
    $type = Storage::mimeType("images/$filename");

    return response($file)->header('Content-Type', $type);
})->where('filename', '(.*)');

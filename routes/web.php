<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\IaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\CheckEnvAuth;
use App\Http\Middleware\SecurityHeaders;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::middleware('CheckEnvAuth', 'SecurityHeaders')->group(function () {
    Route::get('/uploadFiles', [FileController::class,'uploadFiles'])->name('files.uploadFiles');
    Route::get('/downloadFiles', [FileController::class,'downloadFiles'])->name('files.download');
    Route::get('/listFiles', [FileController::class,'listFiles'])->name('files.list');

    Route::get('/showFile', [FileController::class,'showFile'])->name('files.show');
    Route::get('/gallery', [FileController::class,'imageGallery'])->name('files.gallery');
    Route::get('/delete', [FileController::class, 'delete'])->name('files.delete');
    Route::post('/uploadMultipleFiles', [FileController::class, 'uploadAjax'])->name('files.uploadAjax');

    Route::get('/links/listLinks', [LinkController::class,'listLinks'])->name('links.list');
    Route::get('/links/createLink', [LinkController::class,'createLink'])->name('links.new');
    Route::post('/links/saveLink', [LinkController::class,'saveLink'])->name('links.save');
    Route::get('/links/deleteLink', [LinkController::class,'deleteLink'])->name('links.delete');

    Route::get('/ia/pregunta', [IaController::class,'pregunta'])->name('ia.pregunta');
    Route::post('/ia/respuesta', [IaController::class,'obtenerRespuesta'])->name('ia.respuesta');
    
});

Route::get('/', [LoginController::class, 'showLoginForm'])->name('loginForm');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
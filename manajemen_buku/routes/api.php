<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\{
    Buku as Book,
    User
};
use App\Http\Controllers\Authentication;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(["prefix" => "auth"], function(){
    Route::post("/login", [Authentication::class, 'login']);
    Route::post("/register", [Authentication::class, 'register']);

});
Route::group(["prefix" => "book"], function(){
    Route::get("/",[Book::class, 'index'])->name("index.buku");
    Route::post("/", [Book::class, 'store'])->name("store.buku");
    Route::get("/{id}", [Book::class, 'show'])->name("show.buku");
    Route::put("/{id}", [Book::class, 'update'])->name("update.buku");
    Route::delete("/{id}", [Book::class, 'delete'])->name("delete.buku");

});
Route::group(["prefix" => "users"], function(){
    Route::get("/",[User::class, 'index'])->name("index.user");
    Route::post("/", [User::class, 'store'])->name("store.user");
    Route::get("/{id}", [User::class, 'show'])->name("show.user");
    Route::put("/{id}", [User::class, 'update'])->name("update.user");
    Route::delete("/{id}", [User::class, 'delete'])->name("delete.user");
});

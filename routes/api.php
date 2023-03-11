<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Product

Route::get('/products/data', [ProductController\Data::class, 'getData'])->name('products.data');
Route::get('/products/data/{product}', [ProductController\Data::class, 'getProduct']);

Route::post('/products/create', [ProductController\Create::class, 'store'])->name('products.create');

Route::put('/products/update/{product}', [ProductController\Update::class, 'update'])->name('products.update');

Route::post('/products/media/upload', [ProductController\Media::class, 'upload'])->name('products.media.upload');
Route::post('/products/media/add', [ProductController\Media::class, 'add'])->name('products.media.add');

Route::post('/products/editor/upload', [ProductController\Editor::class, 'upload'])->name('products.editor.upload');

Route::get('/products/get_slug', [ProductController\Create::class, 'getSlug'])->name('products.getSlug');

Route::delete('/products/delete/{product}', [ProductController\Delete::class, 'destroy'])->name('products.destory');


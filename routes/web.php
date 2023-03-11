<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProductController\Index::class, 'index'])->name('products');
Route::get('/products/create', [ProductController\Create::class, 'index'])->name('products.create');
Route::get('/products/update/{product}', [ProductController\Update::class, 'index'])->name('products.update');
Route::get('/products/listing/{slug}', [ProductController\Show::class, 'index'])->name('products.show');

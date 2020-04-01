<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/htmlList', 'Controller@htmlList');
Route::get('/bulkUpload', 'Controller@bulkUpload');
Route::get('/categorySchema', function(){
   echo "<ul>";
   echo "<li><a href='".url('documents/categories-table-structure.pdf')."' download>Structure</a></li>";
   echo "<li><a href='".url('documents/categories-designer-schema.png')."' download>Designer</a></li>";
   echo "<li><a href='".url('documents/categories.sql')."' download>Schema</a></li>";
   echo "</ul>";
});
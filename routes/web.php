<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\NewsController;

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
    return view('auth.login');
});
Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard',function (){
        $data['title']='Dashboard';
        return view('admin.dashboard',$data);
    })->name('dashboard');

    Route::resource('user', UserController::class)->except('show');
    Route::resource('news', NewsController::class)->except('show');
    Route::get('news/category/', [NewsCategoryController::class, 'index'])->name('news_category.index');
    Route::get('news/category/create', [NewsCategoryController::class, 'create'])->name('news_category.create');
    Route::post('news/category/store', [NewsCategoryController::class, 'store'])->name('news_category.store');
    Route::put('news/category/update', [NewsCategoryController::class, 'update'])->name('news_category.update');
    Route::delete('news/category/delete/{slug}', [NewsCategoryController::class, 'destroy'])->name('news_category.destroy');
});


Auth::routes(['register' => false]);


<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/login', 'AuthController@showLogin')->name('login');
Route::get('/register', 'AuthController@showRegister')->name('register');


Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth.session'], function() {
    Route::get('/', 'MovieController@index')->name('movies.list');
    Route::get('/movie/{imdbID}', 'MovieController@detail')->name('movies.detail');

    Route::post('/favorite/add', 'FavoriteController@add')->name('favorite.add');
    Route::post('/favorite/remove', 'FavoriteController@remove')->name('favorite.remove');
    Route::get('/favorite', 'FavoriteController@index')->name('favorite.list');
});

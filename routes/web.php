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

Route::get('/', 'App\Http\Controllers\FrontendController@index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/category/overview/{id}', 'App\Http\Controllers\FrontendController@categoryOverview')->name('category.overview');
Route::get('/forum/overview/{id}', 'App\Http\Controllers\FrontendController@forumOverview')->name('forum.overview');

Route::get('/topic', function () {
    return view('client.topic');
});

route::middleware(['auth','admin'])->group(function(){

    route::get('dashboard/home', 'App\Http\Controllers\DashboardController@home');
    route::get('dashboard/category/new', 'App\Http\Controllers\CategoryController@create')->name('category.new');
    route::post('dashboard/category/new', 'App\Http\Controllers\CategoryController@store')->name('category.store');
    route::get('dashboard/categories', 'App\Http\Controllers\CategoryController@index')->name('categories');
    route::get('dashboard/categories/{id}', 'App\Http\Controllers\CategoryController@show')->name('category');
    
    route::get('dashboard/categories/edit/{id}', 'App\Http\Controllers\CategoryController@edit')->name('category.edit');
    route::post('dashboard/categories/edit/{id}', 'App\Http\Controllers\CategoryController@update')->name('category.update');
    route::get('dashboard/categories/delete/{id}', 'App\Http\Controllers\CategoryController@destroy')->name('category.destroy');
    //Forums
    route::get('dashboard/forum/new', 'App\Http\Controllers\ForumController@create')->name('forum.new');
    route::post('dashboard/forum/new', 'App\Http\Controllers\ForumController@store')->name('forum.store');
    route::get('dashboard/forums', 'App\Http\Controllers\ForumController@index')->name('forums');
    
    
    route::get('dashboard/forums/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum');
    route::get('dashboard/forums/edit/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum.edit');
    route::post('dashboard/forums/update/{id}', 'App\Http\Controllers\ForumController@update')->name('forum.update');
    route::get('dashboard/forums/delete/{id}', 'App\Http\Controllers\ForumController@destroy')->name('forum.destroy');
    
route::get('/dashboard/users','App\Http\Controllers\DashboardController@users');
route::get('/dashboard/admin/profile','App\Http\Controllers\DashboardController@profile')->name('admin.profile');
route::get('/dashboard/users/{id}','App\Http\Controllers\DashboardController@show');
route::post('/dashboard/users/{id}','App\Http\Controllers\DashboardController@destroy')->name('user.delete');


route::get('/dashboard/notifications','App\Http\Controllers\DashboardController@notifications')->name('notifications');
route::get('/dashboard/notifications/mark-as-read/{id}','App\Http\Controllers\DashboardController@markAsRead')->name('notification.read');
route::get('/dashboard/notifications/delete/{id}','App\Http\Controllers\DashboardController@notificationDestroy')->name('notification.delete');
route::get('/dashboard/settings/form','App\Http\Controllers\DashboardController@settingsForm')->name('settings.form');
route::post('/dashboard/settings/new','App\Http\Controllers\DashboardController@newSetting')->name('settings.new');


});

//Topics
route::get('client/topic/new/{id}', 'App\Http\Controllers\DiscussionController@create')->name('topic.new');
route::post('client/topic/new', 'App\Http\Controllers\DiscussionController@store')->name('topic.store');
route::get('client/topic/{id}', 'App\Http\Controllers\DiscussionController@show')->name('topic');
route::post('client/topic/{id}', 'App\Http\Controllers\DiscussionController@reply')->name('topic.reply');
route::get('client/topic/remove/{id}', 'App\Http\Controllers\DiscussionController@remove')->name('topic.delete');
route::get('/topic/reply/delete/{id}', 'App\Http\Controllers\DiscussionController@destroy')->name('reply.delete');
/* route::get('dashboard/forums', 'App\Http\Controllers\ForumController@index')->name('forums');


route::get('dashboard/forums/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum');
route::get('dashboard/forums/edit/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum.edit');
route::post('dashboard/forums/update/{id}', 'App\Http\Controllers\ForumController@update')->name('forum.update');
route::get('dashboard/forums/delete/{id}', 'App\Http\Controllers\ForumController@destroy')->name('forum.destroy'); */

route::get('/updates', 'App\Http\Controllers\DiscussionController@updates');
route::post('user/update/{id}', 'App\Http\Controllers\UserController@update')->name('user.update');

//users

route::get('client/user/{id}', 'App\Http\Controllers\FrontendController@profile')->middleware('auth')->name('client.user.profile');
route::get('client/users', 'App\Http\Controllers\FrontendController@users')->middleware('auth')->name('client.users');
route::post('user/photo/update/{id}', 'App\Http\Controllers\FrontendController@photoUpdate')->name('user.photo.update');

route::get('reply/like/{id}', 'App\Http\Controllers\DiscussionController@like')->name('reply.like');
route::get('reply/dislike/{id}', 'App\Http\Controllers\DiscussionController@dislike')->name('reply.dislike');
route::post('category/search', 'App\Http\Controllers\CategoryController@search')->name('category.search');

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

Route::get('/', "HomeController@index")->name("home");
Route::get('/my', "MyController@index")->name("personal.profile")->middleware('auth');
Route::get('/my/edit', "MyController@edit")->name("personal.edit")->middleware('auth');
Route::post('/my/edit', "MyController@patch");
Route::get('/my/applications', "MyController@applications")->name("personal.applications")->middleware('auth');
Route::get('/login', "SessionController@create")->name("login");
Route::post('/login', "SessionController@store");
Route::post('/logout', "SessionController@destroy")->name("logout");
Route::get('/password.request', "SessionController@request")->name("password.request");
Route::post('/password.request', "SessionController@generateToken");
Route::get('/password.set', "SessionController@password")->name("password.set");
Route::post('/password.set', "SessionController@setPassword");
Route::get('/register', "RegistrationController@create")->name("register");
Route::post('/register', "RegistrationController@store");
Route::get('/email.confirmation', "RegistrationController@verify")->name("verify");
Route::post('/email.confirmation', "RegistrationController@confirm")->name("email.confirmation");
Route::get('/email.confirmation.retry/{email}', "RegistrationController@retry")->name("email.confirmation.retry");
Route::get('login/facebook', 'FacebookController@redirectToProvider')->name("facebook");
Route::get('login/facebook/callback', 'FacebookController@handleProviderCallback')->name("facebook.create");
Route::post('login/facebook', 'FacebookController@store')->name("facebook.register");

Route::get('/sign/{group}', "HomeController@sign")->name("sign")->middleware('can:create,App\Application');
Route::get('/leave/{group}', "HomeController@leave")->name("leave")->middleware('can:leave,group');
Route::get('/users', "UsersController@index")->name("users")->middleware('can:viewList,App\User');
Route::get('/users/create', "UsersController@create")->middleware('can:create,App\User');
Route::get('/users/{user}', "UsersController@show")->middleware('can:view,user')->name("users.show");
Route::post('/users/create', "UsersController@store")->middleware('can:create,App\User');
Route::get('/users/{user}/edit', "UsersController@edit")->middleware('can:update,user');
Route::post('/users/{user}/edit', "UsersController@patch")->middleware('can:update,user');
Route::get('/users/{user}/delete', "UsersController@destroy")->middleware('can:delete,user');
Route::get('/users/{user}/ban', "UsersController@ban")->middleware('can:ban,user');
Route::get('/users/{user}/unban', "UsersController@unban")->middleware('can:ban,user');
Route::get('/users/{user}/password', "UsersController@password")->middleware('can:update,user');
Route::post('/users/{user}/password', "UsersController@storePassword")->middleware('can:update,user');
Route::get('/actions', "ActionsController@index")->name("actions")->middleware('can:viewList,App\Action');
Route::get('/actions/create', "ActionsController@create")->middleware('can:create,App\Action');
Route::post('/actions/create', "ActionsController@store")->middleware('can:create,App\Action');
Route::get('/actions/{action}', "ActionsController@show")->name("actions.show")->middleware('can:view,action');
Route::get('/actions/{action}/edit', "ActionsController@edit")->middleware('can:update,action');
Route::post('/actions/{action}/edit', "ActionsController@patch")->middleware('can:update,action');
Route::get('/actions/{action}/delete', "ActionsController@destroy")->middleware('can:delete,action');
Route::get('/actions/{action}/activate', "ActionsController@activate")->middleware('can:activate,action');
Route::get('/actions/{action}/deactivate', "ActionsController@deactivate")->middleware('can:activate,action');
Route::get('/actions/{action}/publish', "ActionsController@publish")->middleware('can:activate,action');
Route::get('/actions/{action}/hide', "ActionsController@hide")->middleware('can:activate,action');
Route::get('/actions/{action}/open', "ActionsController@open")->middleware('can:open,action');
Route::get('/actions/{action}/close', "ActionsController@close")->middleware('can:open,action');
Route::get('/groups', "GroupsController@index")->name("groups")->middleware('can:viewList,App\Group');
Route::get('/groups/create', "GroupsController@create")->middleware('can:create,App\Group');
Route::post('/groups/create', "GroupsController@store")->middleware('can:create,App\Group');
Route::get('/groups/{group}', "GroupsController@show")->name("groups.show")->middleware('can:view,group');
Route::get('/groups/{group}/edit', "GroupsController@edit")->middleware('can:update,group');
Route::post('/groups/{group}/edit', "GroupsController@patch")->middleware('can:update,group');
Route::get('/groups/{group}/delete', "GroupsController@destroy")->middleware('can:delete,group');
Route::get('/groups/{group}/open', "GroupsController@open")->middleware('can:open,group');
Route::get('/groups/{group}/close', "GroupsController@close")->middleware('can:open,group');
Route::get('/groups/{group}/print.certificates', "GroupsController@certificates")->middleware('can:certificates,group');
Route::get('/groups/{group}/print.list', "GroupsController@participants")->middleware('can:certificates,group');
Route::get('/applications', "ApplicationsController@index")->name("applications")->middleware('can:viewList,App\Application');
Route::get('/applications/create', "ApplicationsController@create")->middleware('can:create,App\Application');
Route::post('/applications/create', "ApplicationsController@store")->middleware('can:create,App\Application');
Route::get('/applications/{application}', "ApplicationsController@show")->name("applications.show")->middleware('can:view,application');
Route::get('/applications/{application}/delete', "ApplicationsController@destroy")->middleware('can:delete,application');
Route::get('/applications/{application}/cancel', "ApplicationsController@cancel")->middleware('can:cancel,application');
Route::get('/certificates/create', "CertificatesController@create")->middleware('can:create,App\Application');
Route::post('/certificates/create', "CertificatesController@build")->middleware('can:create,App\Application');
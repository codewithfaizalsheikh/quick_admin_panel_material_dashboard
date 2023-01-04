<?php

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');
Auth::routes(['register' => false]);

//use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\CategoriesController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    //Events
    Route::get('/events', [EventsController::class, 'index'])->name("events.index");
    Route::get('/events/create', [EventsController::class, 'create'])->name("events.create");
    Route::post('/events/store', [EventsController::class, 'store'])->name("events.store");
    Route::get('/events/edit/{id}', [EventsController::class, 'edit'])->name("events.edit");
    Route::get('/events/images/{id}', [EventsController::class, 'event_images'])->name("events.images");
    Route::post('/events/update/{id}', [EventsController::class, 'update'])->name("events.update");
    Route::post('/events/add_images/{id}', [EventsController::class, 'add_event_images'])->name("events.add_event_images");
    Route::get('/events/delete/{id}', [EventsController::class, 'delete'])->name("events.delete");
    Route::get('/events/delete_images/{event_id}/{image_id}', [EventsController::class, 'delete_images'])->name("events.delete_images");
    Route::get('/events/detail/{id}',[EventsController::class,'show'])->name("events.show");


    //category
    Route::get('/category', [CategoriesController::class, 'index'])->name("category.index");
    Route::get('/category/create', [CategoriesController::class, 'create'])->name("category.create");
    Route::post('/category/store', [CategoriesController::class, 'store'])->name("category.store");
    Route::get('/category/edit/{id}', [CategoriesController::class, 'edit'])->name("category.edit");
    Route::post('/category/update/{id}', [CategoriesController::class, 'update'])->name("category.update");
    Route::get('/category/delete/{id}', [CategoriesController::class, 'delete'])->name("category.delete");


});

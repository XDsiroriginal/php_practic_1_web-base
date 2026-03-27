<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/equipment', [Controller\Site::class, 'equipment']);
Route::add('GET', '/repair', [Controller\Site::class, 'repair']);
Route::add('GET', '/department', [Controller\Site::class, 'department']);

Route::add('GET', '/admin_control/department_control', [Controller\Site::class, 'department_control'])->middleware('admin');
Route::add('GET', '/admin_control/equipment_control', [Controller\Site::class, 'equipment_control'])->middleware('admin');
Route::add('GET', '/admin_control/user_control', [Controller\Site::class, 'user_control'])->middleware('admin');
Route::add('GET', '/admin_control/user_control/add_user', [Controller\Site::class, 'user_create'])->middleware('admin');
Route::add('GET', '/admin_control/user_control/user_details', [Controller\Site::class, 'user_details'])->middleware('admin');

Route::add('GET', '/error_403', [Controller\Site::class, 'error_403']);

<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup'])->middleware('auth', 'admin');
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout'])->middleware('auth');
Route::add('GET', '/equipment', [Controller\userController\EquipmentController::class, 'equipment'])->middleware('auth');
Route::add('GET', '/repair', [Controller\Site::class, 'repair'])->middleware('auth');
Route::add('GET', '/department', [Controller\userController\DepartmentController::class, 'department'])->middleware('auth');

Route::add('GET', '/admin_control/department_control', [Controller\adminControl\DepartmentControlController::class, 'departmentControl'])->middleware('admin', 'auth');
Route::add('GET', '/admin_control/equipment_control', [Controller\adminControl\EquipmentControlController::class, 'equipmentControl'])->middleware('admin', 'auth');
Route::add('GET', '/admin_control/user_control', [Controller\Site::class, 'user_control'])->middleware('admin', 'auth');
Route::add('GET', '/admin_control/user_control/add_user', [Controller\Site::class, 'user_create'])->middleware('admin', 'auth');
Route::add('GET', '/admin_control/user_control/user_details', [Controller\Site::class, 'user_details'])->middleware('admin', 'auth');

Route::add('GET', '/errors/error_403', [Controller\Site::class, 'error_403']);

Route::add(['GET', 'POST'], '/admin_control/department_control/department_add', [Controller\adminControl\DepartmentControlController::class, 'addDepartment'])->middleware('admin', 'auth');
Route::add(['GET', 'POST'], '/admin_control/department_control/department_change', [Controller\adminControl\DepartmentControlController::class, 'changeDepartment'])->middleware('admin', 'auth');

Route::add(['GET', 'POST'], '/admin_control/equipment_control/equipment_add', [Controller\adminControl\DepartmentControlController::class, 'addEquipment'])->middleware('admin', 'auth');

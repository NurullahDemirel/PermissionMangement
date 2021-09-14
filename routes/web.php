<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

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


Route::get('/manage/user',[UserController::class,'index'])->name('mange-user')->middleware('can:create user');//ana yönetim paneli

Route::get('edit/permisson/{id}',[UserController::class,'editPermission'])->name('edit-permisson');//izin ekleme çıkarma get

Route::get('edit/role',[RoleController::class,'index'])->name('role-manage');//role yönetim paneli view
Route::get('delete/role/{id}',[RoleController::class,'deleteRole'])->name('delete-role');//role silme
Route::post('create/role/',[RoleController::class,'createRole'])->name('create-role');//role oluşturma
Route::post('save/permissons',[RoleController::class,'newPermissonOfRole'])->name('new-role-permission');//yeni rolleri gönderdiğimşz post fonksiyon

Route::get('role/{id}',[UserController::class,'editRole'])->name('edit-role');//role düzenleme view
Route::post('role/user/edit',[UserController::class,'editUserRole'])->name('user-roles-edit');//role düzenleme post
Route::get('edit/user/{id}',[UserController::class,'editUser'])->name('edit-user');//kişini detaylarını düzenleme get
Route::get('delete/user/{id}',[UserController::class,'deleteUser'])->name('delete-user');//kişiyi silme
Route::get('kayit/tamamla/{activate_code}',[UserController::class,'tamamla'])->name('aktif-et');//kayıt tamamlama view
Route::post('kayit/tamamla/{activate_code}',[UserController::class,'Detaylar'])->name('aktif-tamamla');//kayıt tamamlama post
Route::post('/permissions/edit/{id}',[UserController::class,'getNewPermission'])->name('permissions-edit');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

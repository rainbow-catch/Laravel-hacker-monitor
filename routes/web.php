<?php

use App\Http\Controllers\ConnectLogController;
use App\Http\Controllers\FTPController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\LicenseSettingController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LogController2;
use App\Http\Controllers\DownController;
use App\Http\Controllers\ScreenShotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\DataController;
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
    return redirect('/login');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/ftp', [FTPController::class, 'index'])->name('ftp');

Route::group(['prefix' => 'ftp'], function () {
    Route::post('/login', [FTPController::class, 'login'])->name('ftplogin');
    Route::get('/install', [FTPController::class, 'install']);
    Route::get('/reinstall', [FTPController::class, 'reinstall']);
    Route::get('/uninstall', [FTPController::class, 'uninstall']);
});

Route::group(['prefix' => 'admin'], function () {
Route::get('/users',  [UserManageController::class, 'index'])->name('usersManagement')->middleware('auth');
Route::post('/users/changePassword',  [UserManageController::class, 'changePassword'])->name('changePassword')->middleware('auth');
Route::post('/users/changeAvatar',  [UserManageController::class, 'changeAvatar'])->name('changeAvatar')->middleware('auth');
Route::get('/getUsers',  [UserManageController::class, 'getUser'])->name('getUsers')->middleware('auth');
Route::get('/user_save',  [UserManageController::class, 'user_save'])->name('userSaved')->middleware('auth');
Route::get('/user_delete',  [UserManageController::class, 'user_delete'])->name('user_delete')->middleware('auth');
Route::get('/approve',  [UserManageController::class, 'approve'])->name('approve')->middleware('auth');

Route::get('/licenseSetting', [LicenseSettingController::class, 'index'])->name('licenseSetting')->middleware('auth');
Route::post('/licenseSetting/save', [LicenseSettingController::class, 'save'])->name('licenseSetting.save')->middleware('auth');

});

Route::get('/screenshots',  [ScreenShotController::class, 'folders'])->name('screenshots')->middleware('auth');
Route::get('/screenshots/delete',  [ScreenShotController::class, 'delfolder'])->middleware('auth');
Route::get('/screenimages/{folder}',  [ScreenShotController::class, 'images'])->name('screenimages')->middleware('auth');
Route::post('/screenshot',  [ScreenShotController::class, 'image'])->name('screenshot')->middleware('auth');
Route::post('/screenshot/delete',  [ScreenShotController::class, 'delete'])->name('screenshot')->middleware('auth');

Route::get('/logs',  [LogController::class, 'logfiles'])->name('logs')->middleware('auth');
Route::get('/log/{file}',  [LogController::class, 'logcontent'])->middleware('auth');
Route::post('/log/delete',  [LogController::class, 'delete'])->middleware('auth');

Route::get('/cnlogs',  [ConnectLogController::class, 'logfiles'])->name('cnlogs')->middleware('auth');
Route::get('/cnlog/{file}',  [ConnectLogController::class, 'logcontent'])->middleware('auth');
Route::post('/cnlog/delete',  [ConnectLogController::class, 'delete'])->middleware('auth');

Route::post('/ban/add',  [LogController::class, 'banadd'])->middleware('auth');
Route::post('/ban/delete',  [LogController::class, 'bandelete'])->middleware('auth');

Route::get('/guides', [LogController2::class, 'index'])->name('guides');

Route::get('/downloads', [DownController::class, 'index'])->name('downloads');
Route::post('/downloads/save/{id}', [DownController::class, 'save'])->name('downloads.save');
Route::post('/downloads/logs/save', [DownController::class, 'saveLog'])->name('downloads.logs.save');
Route::post('/downloads/logs/save/{id}', [DownController::class, 'saveLog'])->name('downloads.logs.save');
Route::delete('/downloads/logs/delete/{id}', [DownController::class, 'deleteLog'])->name('downloads.logs.delete');

Route::get('/license', [LicenseController::class, 'index'])->name('license');
Route::get('/license/generate', [LicenseController::class, 'generate']);




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

Route::group(['prefix' => 'ftp'], function () {
    Route::post('/login', [FTPController::class, 'login'])->name('ftplogin');
    Route::get('/install', [FTPController::class, 'install']);
    Route::get('/reinstall', [FTPController::class, 'reinstall']);
    Route::get('/uninstall', [FTPController::class, 'uninstall']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/ftp', [FTPController::class, 'index'])->name('ftp');

    Route::group(['middleware' => 'checkPermission:see_home'], function() {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });

    Route::group(['middleware' => 'checkRole:3'], function () {
        Route::group(['prefix' => 'admin'], function(){
            Route::get('/users', [UserManageController::class, 'index'])->name('usersManagement');
            Route::get('/user_save', [UserManageController::class, 'user_save'])->name('userSaved');
            Route::get('/getUsers', [UserManageController::class, 'getUser'])->name('getUsers');
            Route::get('/approve', [UserManageController::class, 'approve'])->name('approve');
        });

        Route::delete('/downloads/delete/{id}', [DownController::class, 'delete'])->name('downloads.delete');
        Route::post('/downloads/save', [DownController::class, 'save'])->name('downloads.save');
        Route::post('/downloads/save/{id}', [DownController::class, 'save'])->name('downloads.save');
        Route::post('/downloads/logs/save', [DownController::class, 'saveLog'])->name('downloads.logs.save');
        Route::post('/downloads/logs/save/{id}', [DownController::class, 'saveLog'])->name('downloads.logs.save');
        Route::delete('/downloads/logs/delete/{id}', [DownController::class, 'deleteLog'])->name('downloads.logs.delete');
    });

    Route::group(['middleware' => 'checkPermission:see_screenshots'], function() {
        Route::get('/screenshots', [ScreenShotController::class, 'folders'])->name('screenshots');
        Route::get('/screenimages/{folder}', [ScreenShotController::class, 'images'])->name('screenimages');
        Route::post('/screenshot', [ScreenShotController::class, 'image'])->name('screenshot');
    });

    Route::group(['middleware' => 'checkPermission:see_hack_logs'], function() {
        Route::get('/logs', [LogController::class, 'logfiles'])->name('logs');
        Route::get('/log/{file}', [LogController::class, 'logcontent']);
    });

    Route::group(['middleware' => 'checkPermission:see_connect_logs'], function() {
        Route::get('/cnlogs', [ConnectLogController::class, 'logfiles'])->name('cnlogs');
        Route::get('/cnlog/{file}', [ConnectLogController::class, 'logcontent']);
    });

    Route::group(['middleware' => 'checkPermission:see_tools_download'], function() {
        Route::get('/downloads', [DownController::class, 'index'])->name('downloads');
    });

    Route::group(['middleware' => 'checkPermission:ban_hardware'], function() {
        Route::post('/ban/add', [LogController::class, 'banadd']);
        Route::post('/ban/delete', [LogController::class, 'bandelete']);
    });


    Route::group(['middleware' => 'checkPermission:see_guides'], function() {
        Route::get('/guides', [LogController2::class, 'index'])->name('guides');
    });

    Route::group(['middleware' => 'checkRole:2|3'], function () {
        Route::post('/users/changePassword', [UserManageController::class, 'changePassword'])->name('changePassword');
        Route::post('/users/changeAvatar', [UserManageController::class, 'changeAvatar'])->name('changeAvatar');
        Route::get('/guest_save', [UserManageController::class, 'guest_save'])->name('guestSaved');
        Route::get('/user_delete', [UserManageController::class, 'user_delete'])->name('user_delete');

        Route::get('/screenshots/delete', [ScreenShotController::class, 'delfolder']);
        Route::post('/screenshot/delete', [ScreenShotController::class, 'delete'])->name('screenshot');

        Route::post('/log/delete', [LogController::class, 'delete']);

        Route::post('/cnlog/delete', [ConnectLogController::class, 'delete']);

        Route::get('/license', [LicenseController::class, 'index'])->name('license');
        Route::get('/license/generate', [LicenseController::class, 'generate']);
        Route::get('/licenseSetting', [LicenseSettingController::class, 'index'])->name('licenseSetting');
    });
});

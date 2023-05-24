<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\admin\WebSettingController;
use App\Http\Controllers\admin\UserController;
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

Route::get('/', function () {
    return redirect()->route('admin.login');
});
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/logout', [LoginController::class, 'logout']);

Route::controller(UserController::class)->group(function () {

    /* User Route Update */
    Route::get('/user/all', 'allUser')->name('view.user');
    Route::get('/user/add', 'addUser')->name('add.user');
    Route::get('/user/edit/{id}', 'editUser')->name('edit.user');
    Route::post('/user/remove-industry', 'removeUser')->name('delete.user');
    Route::post('/user/restore-industry', 'restoreUser')->name('restore.user');
    Route::post('/user/update-industry-status', 'updateUserStatus')->name('updatestatus.user');
    Route::post('/user/add-industry-process', 'addUserProcess')->name('add.user.process');
    Route::post('/user/update-industry-process', 'updateUserProcess')->name('update.user.process');
    Route::get('/user/trash', 'trashUser')->name('trash.user');
    /* End User section Routes */
});

Route::controller(WebSettingController::class)->group(function () {

    Route::get('/web/settings', 'settings')->name('web.settings');
    Route::post('/web/social-link-process', 'socialLinkProcess')->name('web.social.link.process');
    Route::post('/web/contact-info-process', 'contactInfoProcess')->name('contact.info.process');
    Route::post('/web/web-logos-process', 'webLogosProcess')->name('web.logos.process');
    Route::post('/web/smtp-setting-process', 'smtpSettingProcess')->name('web.stmpsetting.process');
    Route::post('/web/intro-process', 'introProcess')->name('web.introsetting.process');
    Route::get('/clear-cache', 'clearCache');
    Route::get('/cache-web', 'cacheWeb');
});

Auth::routes();

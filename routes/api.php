<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('hello', function () {
        echo 
        "Hello";
    });

    // proposal
    //Admin
    Route::group(['prefix' => 'admin'], function() {
        Route::get('/home', [App\Http\Controllers\API\Admin\ProposalController::class, 'index'])->name('dashboard_admin');
        route::get('/list-pengajuan', [App\Http\Controllers\API\Admin\ProposalController::class, 'proposal'])->name('list-pengajuan');
        route::get('/pengumuman', [App\Http\Controllers\API\Proposal\ProposalController::class, 'pengumuman']);
        
        Route::group(['prefix' => 'ormawa'], function () {
            route::get('/', [App\Http\Controllers\API\Admin\OrmawaController::class, 'index'])->name('admin.ormawa');
            route::post('/', [App\Http\Controllers\API\Admin\OrmawaController::class, 'insert'])->name('admin.ormawa.insert');
            route::delete('/', [App\Http\Controllers\API\Admin\OrmawaController::class, 'delete'])->name('admin.ormawa.delete');
            route::put('/', [App\Http\Controllers\API\Admin\OrmawaController::class, 'update'])->name('admin.ormawa.update');
        });
        
        Route::group(['prefix' => 'users'], function () {
            route::get('/', [App\Http\Controllers\API\Admin\UserController::class, 'index'])->name('admin.user');
            route::post('/', [App\Http\Controllers\API\Admin\UserController::class, 'insert'])->name('admin.user.insert');
            route::delete('/', [App\Http\Controllers\API\Admin\UserController::class, 'delete'])->name('admin.user.delete');
            route::put('/', [App\Http\Controllers\API\Admin\UserController::class, 'update'])->name('admin.user.update');
        });

        Route::group(['prefix' => 'proposal'], function () {
            route::get('/list-pengajuan', [App\Http\Controllers\API\Admin\ProposalController::class, 'proposal'])->name('list-pengajuan-admin');
            route::get('/detail-pengajuan/{id}', [App\Http\Controllers\API\Admin\ProposalController::class, 'detail'])->name('admin.pengajuan.detail');
        });
    });

    //Bem
    Route::group(['prefix' => 'bem'], function() {
        Route::get('/home', [App\Http\Controllers\API\Admin\ProposalController::class, 'index'])->name('dashboard_bem');
            route::get('/list-pengajuan', [App\Http\Controllers\API\Bem\ProposalController::class, 'proposal'])->name('list-pengajuan-bem');
            route::get('/detail-pengajuan/{id}', [App\Http\Controllers\API\Bem\ProposalController::class, 'detail'])->name('pengajuan.detail');
            route::post('/approve', [App\Http\Controllers\API\Bem\ProposalController::class, 'approve'])->name('pengajuan.approve');
            route::post('/reject', [App\Http\Controllers\API\Bem\ProposalController::class, 'reject'])->name('pengajuan.reject');

            route::get('/create', [App\Http\Controllers\API\Bem\ProposalController::class, 'create'])->name('nambah-pengajuan');
            route::get('/edit/{id}', [App\Http\Controllers\API\Bem\ProposalController::class, 'edit'])->name('edit-pengajuan');
            route::post('/pengajuan', [App\Http\Controllers\API\Bem\ProposalController::class, 'store'])->name('pengajuan-bem');
            route::put('/update/{id}', [App\Http\Controllers\API\Bem\ProposalController::class, 'update'])->name('update-pengajuan');
            route::get('/delete/{id}', [App\Http\Controllers\API\Bem\ProposalController::class, 'destroy'])->name('delete-pengajuan');
            route::get('/pengumuman', [App\Http\Controllers\API\Bem\ProposalController::class, 'pengumuman'])->name('pengumuman-bem');
            route::get('/terima/{id}', [App\Http\Controllers\API\Bem\ProposalController::class, 'terima'])->name('terima-pengajuan');
            route::get('/tolak/{id}', [App\Http\Controllers\API\Bem\ProposalController::class, 'tolak'])->name('tolak-pengajuan');
    }); 

    //Ormawa
    Route::group(['prefix' => 'ormawa'], function() {
            Route::get('/home', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'index'])->name('dashboard_ormawa');    
            route::get('/list-pengajuan', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'proposal'])->name('list-pengajuan-ormawa');
            route::get('/create', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'create'])->name('tambah-pengajuan');
            route::get('/edit/{id}', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'edit'])->name('ubah-pengajuan');
            route::put('/update', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'update'])->name('update-pengajuan-ormawa');
            route::post('/pengajuan', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'store'])->name('pengajuan-ormawa');
            route::get('/delete/{id}', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'destroy'])->name('delete-pengajuan-ormawa');
            
            route::get('/ajukan-ulang/{id}', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'pengajuanUlang'])->name('pengajuanUlang');
            route::put('/update-pengajuan-ulang', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'updatePengajuanUlang'])->name('update-pengajuan-ulang');
            route::post('/lampiran-lpj', [App\Http\Controllers\API\Ormawa\ProposalController::class, 'lpj'])->name('lampiran.lpj');
    }); 

});

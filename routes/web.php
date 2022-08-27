<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('Pengguna.login');
})->name('login');

Route::post('/postlogin', [App\Http\Controllers\LoginController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// proposal
//Admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth','ceklevel:admin_mhs']], function() {
    Route::get('/home', [App\Http\Controllers\Admin\ProposalController::class, 'index'])->name('dashboard_admin');
    route::get('/list-pengajuan', [App\Http\Controllers\Admin\ProposalController::class, 'proposal'])->name('list-pengajuan');
    route::get('/pengumuman', [App\Http\Controllers\Proposal\ProposalController::class, 'pengumuman']);
    
    Route::group(['prefix' => 'ormawa'], function () {
        route::get('/', [App\Http\Controllers\Admin\OrmawaController::class, 'index'])->name('admin.ormawa');
        route::post('/', [App\Http\Controllers\Admin\OrmawaController::class, 'insert'])->name('admin.ormawa.insert');
        route::delete('/', [App\Http\Controllers\Admin\OrmawaController::class, 'delete'])->name('admin.ormawa.delete');
        route::put('/', [App\Http\Controllers\Admin\OrmawaController::class, 'update'])->name('admin.ormawa.update');
    });
    
    Route::group(['prefix' => 'users'], function () {
        route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user');
        route::post('/', [App\Http\Controllers\Admin\UserController::class, 'insert'])->name('admin.user.insert');
        route::delete('/', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('admin.user.delete');
        route::put('/', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user.update');
    });

    Route::group(['prefix' => 'proposal'], function () {
        route::get('/list-pengajuan', [App\Http\Controllers\Admin\ProposalController::class, 'proposal'])->name('list-pengajuan-admin');
        route::get('/detail-pengajuan/{id}', [App\Http\Controllers\Admin\ProposalController::class, 'detail'])->name('admin.pengajuan.detail');
    });
});

//Bem
Route::group(['prefix' => 'bem', 'middleware' => ['auth','ceklevel:bem']], function() {
    Route::get('/home', [App\Http\Controllers\Admin\ProposalController::class, 'index'])->name('dashboard_bem');
        route::get('/list-pengajuan', [App\Http\Controllers\Bem\ProposalController::class, 'proposal'])->name('list-pengajuan-bem');
        route::get('/detail-pengajuan/{id}', [App\Http\Controllers\Bem\ProposalController::class, 'detail'])->name('pengajuan.detail');
        route::post('/approve', [App\Http\Controllers\Bem\ProposalController::class, 'approve'])->name('pengajuan.approve');
        route::post('/reject', [App\Http\Controllers\Bem\ProposalController::class, 'reject'])->name('pengajuan.reject');

        route::get('/create', [App\Http\Controllers\Bem\ProposalController::class, 'create'])->name('nambah-pengajuan');
        route::get('/edit/{id}', [App\Http\Controllers\Bem\ProposalController::class, 'edit'])->name('edit-pengajuan');
        route::post('/pengajuan', [App\Http\Controllers\Bem\ProposalController::class, 'store'])->name('pengajuan-bem');
        route::put('/update/{id}', [App\Http\Controllers\Bem\ProposalController::class, 'update'])->name('update-pengajuan');
        route::get('/delete/{id}', [App\Http\Controllers\Bem\ProposalController::class, 'destroy'])->name('delete-pengajuan');
        route::get('/pengumuman', [App\Http\Controllers\Bem\ProposalController::class, 'pengumuman'])->name('pengumuman-bem');
        route::get('/terima/{id}', [App\Http\Controllers\Bem\ProposalController::class, 'terima'])->name('terima-pengajuan');
        route::get('/tolak/{id}', [App\Http\Controllers\Bem\ProposalController::class, 'tolak'])->name('tolak-pengajuan');
}); 

//Ormawa
Route::group(['prefix' => 'ormawa', 'middleware' => ['auth','ceklevel:ormawa']], function() {
        Route::get('/home', [App\Http\Controllers\Ormawa\ProposalController::class, 'index'])->name('dashboard_ormawa');    
        route::get('/list-pengajuan', [App\Http\Controllers\Ormawa\ProposalController::class, 'proposal'])->name('list-pengajuan-ormawa');
        route::get('/create', [App\Http\Controllers\Ormawa\ProposalController::class, 'create'])->name('tambah-pengajuan');
        route::get('/edit/{id}', [App\Http\Controllers\Ormawa\ProposalController::class, 'edit'])->name('ubah-pengajuan');
        route::put('/update', [App\Http\Controllers\Ormawa\ProposalController::class, 'update'])->name('update-pengajuan-ormawa');
        route::post('/pengajuan', [App\Http\Controllers\Ormawa\ProposalController::class, 'store'])->name('pengajuan-ormawa');
        route::get('/delete/{id}', [App\Http\Controllers\Ormawa\ProposalController::class, 'destroy'])->name('delete-pengajuan-ormawa');
        
        route::get('/ajukan-ulang/{id}', [App\Http\Controllers\Ormawa\ProposalController::class, 'pengajuanUlang'])->name('pengajuanUlang');
        route::put('/update-pengajuan-ulang', [App\Http\Controllers\Ormawa\ProposalController::class, 'updatePengajuanUlang'])->name('update-pengajuan-ulang');
        route::post('/lampiran-lpj', [App\Http\Controllers\Ormawa\ProposalController::class, 'lpj'])->name('lampiran.lpj');
}); 

<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/* ───── ① トップページ ───── */
Route::redirect('/', '/posts');   // ルートを投稿一覧へリダイレクト

/* ───── ② 投稿（閲覧は誰でも / 編集系は認証）───── */
Route::get('/posts', [PostController::class, 'index'])
     ->name('posts.index');                // ← ルート名に 'posts.index' 等が付く

Route::middleware(['auth'])->group(function () {
    // 作成・保存・編集・更新・削除
    Route::resource('posts', PostController::class)
         ->only(['show','create', 'store', 'edit', 'update', 'destroy'])
         ->names('posts');
});


/* ───── ③ ユーザーダッシュボード ───── */


/* ───── ④ プロフィール ───── */
Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    // 退会用ルート
Route::delete('/account', [AccountController::class, 'destroy'])
     ->middleware('auth')
     ->name('account.destroy');

// ログインフォーム
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
     ->name('login');
});


require __DIR__.'/auth.php';
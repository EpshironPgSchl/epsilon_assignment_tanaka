<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * アカウント（ユーザー）を論理削除してログアウトし、
     * ログイン画面にリダイレクトします。
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user) {
            // Userモデルに SoftDeletes が効いていれば deleted_at がセットされる
            $user->delete();
        }

        // セッション破棄・ログアウト
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ログイン画面へリダイレクト
        return redirect()->route('login');
    }
}
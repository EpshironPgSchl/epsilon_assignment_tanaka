<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AccountDeletionHidesPostsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function deleting_account_soft_deletes_user_posts()
    {
        // 1. テスト用ユーザーとその投稿を用意
        $user = User::factory()->create();
        $posts = Post::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        // 2. そのユーザーとして「退会」処理を呼び出し
        //    routes/web.php で名前付きルート 'account.destroy' が設定されている想定
        $this->actingAs($user)
             ->delete(route('account.destroy'))
             ->assertRedirect(route('login')); // 退会後はログイン画面へ

        // 3. users テーブルに deleted_at がセットされているか
        $this->assertSoftDeleted('users', ['id' => $user->id]);

        // 4. posts テーブルにも deleted_at がセットされ、一覧取得にも含まれないか
        foreach ($posts as $post) {
            // 論理削除フラグが立っているか
            $this->assertSoftDeleted('posts', ['id' => $post->id]);

            // グローバルスコープで除外されているか
            $this->assertNull(
                Post::find($post->id),
                "投稿ID {$post->id} が論理削除後も取得できてしまいました。"
            );
        }
    }
}
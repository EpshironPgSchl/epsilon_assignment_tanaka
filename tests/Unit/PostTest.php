<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_can_be_created_updated_and_deleted()
    {
        $user = User::factory()->create();

        // 保存
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => '初投稿',
            'body' => '本文テスト',
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => '初投稿',
        ]);

        // 更新
        $post->update(['title' => '更新後のタイトル']);

        $this->assertDatabaseHas('posts', [
            'title' => '更新後のタイトル',
        ]);

        // 削除（論理削除）
        $post->delete();

        $this->assertSoftDeleted('posts', [
            'id' => $post->id,
        ]);
    }
        public function test_posts_from_soft_deleted_users_are_not_included()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Post::factory()->create(['user_id' => $user1->id, 'title' => '有効ユーザーの投稿']);
        Post::factory()->create(['user_id' => $user2->id, 'title' => '削除ユーザーの投稿']);

        // ユーザー2を論理削除
        $user2->delete();

        // 「論理削除されたユーザーの投稿を除く」ロジックを Post モデルに実装しておく必要があります（後述）
        $posts = Post::whereHas('user', function ($q) {
            $q->whereNull('deleted_at');
        })->get();

        $this->assertCount(1, $posts);
        $this->assertEquals('有効ユーザーの投稿', $posts->first()->title);
    }
}
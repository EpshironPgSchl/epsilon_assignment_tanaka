<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_posts_index()
    {
        $this->get('/posts')->assertRedirect('/login');
    }

    public function test_user_can_create_update_and_delete_post()
    {
        $user = User::factory()->create();
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post  = Post::factory()->create(['user_id' => $owner->id]);

        // 作成
        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'タイトル',
            'body'  => '本文',
        ]);
        $postId = $response->assertRedirect('/posts')->getSession()->get('post_id');
        $this->assertDatabaseHas('posts', ['id' => $postId, 'title' => 'タイトル']);

        // 表示
        $this->get("/posts/{$postId}")
             ->assertStatus(200)
             ->assertSee('タイトル');

        // 編集
        $this->actingAs($user)->put("/posts/{$postId}", [
            'title' => '更新タイトル',
            'body'  => '更新本文',
        ])->assertRedirect("/posts?{$postId}");
        $this->assertDatabaseHas('posts', ['id' => $postId, 'title' => '更新タイトル']);

        // 削除（ソフトデリート）
        $this->actingAs($user)->delete("/posts/{$postId}")
             ->assertRedirect('/posts');
        $this->assertSoftDeleted('posts', ['id' => $postId]);
    }

    public function test_other_user_cannot_edit_or_delete_post()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post  = Post::factory()->create(['user_id' => $owner->id]);

      // NG: 名前付き引数を使っている → シグネチャと合わずエラー
$this->actingAs($other)
     ->put("/posts/{$post->id}", ['title'=>'x','body'=>'x'])
     ->assertStatus(403);

$this->actingAs($other)
     ->delete("/posts/{$post->id}")
     ->assertStatus(403);
}
}
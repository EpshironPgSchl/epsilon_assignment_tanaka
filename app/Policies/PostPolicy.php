<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
                // 認証済みであれば一覧閲覧を許可
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
                // すべての投稿を閲覧可（もしくは自分の投稿だけに制限する場合は下行をコメントアウト）
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
                // ログインユーザーは誰でも作成可
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
       
    
        return $user->id === $post->user_id;   // 自分の投稿だけ更新可
    }
    

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
                // 自分がオーナーの投稿のみ削除可
        return $user->id === $post->user_id;
    }
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
                // 自分がオーナーの投稿のみ復元可
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
}
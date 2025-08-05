<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected static function booted()
    {
        static::deleting(function (User $user) {
            // ユーザー削除時に、そのユーザーの投稿をソフトデリート
            $user->posts()->delete();
        });
        static::restoring(function (User $user) {
            // ユーザー復元時に、投稿もまとめて復元
            $user->posts()->withTrashed()->restore();
        });
    }

    /**
     * ユーザーが所有する投稿
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // app/Models/User.php



}

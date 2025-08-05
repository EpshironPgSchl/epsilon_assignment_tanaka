<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'body', 'user_id', 'eyecatch'];

    /**
     * 投稿の所有者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
public function scopeVisible($query)
{
    return $query->whereHas('user', fn($q) => $q->whereNull('deleted_at'));
}
}

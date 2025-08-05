<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => 'サンプル投稿',
            'body' => 'これはサンプルの投稿内容',
            'created_at' => now(),
            'updated_at' =>now(),
        ]);
    }
}

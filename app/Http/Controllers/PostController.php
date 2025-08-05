<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
  

    public function index()
{
      
    $posts =Post::latest()->paginate(10);
        return view('posts.index',['posts'=>$posts]);
        
    }
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:120',
        'body'  => 'required|max:100',
    ]);

    // 投稿作成とユーザーIDの紐付け
    $post = Post::create($validated + ['user_id' => $request->user()->id]);

    // 作成した投稿IDをセッションにフラッシュ
    return redirect()->route('posts.index')
                     ->with([
                         'status'  => '投稿しました！',
                         'post_id' => $post->id,
                     ]);
}

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
          return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
         $data = old() ?: $post;
         return view('posts.edit', compact('post', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Post $post)
{
    $this->authorize('update', $post);   // ← authorize で OK

    $validated = $request->validate([
        'title' => 'required|max:120',
        'body'  => 'required|max:10000',
    ]);

    $post->update($validated);

    return redirect()->route('posts.index', $post)
                     ->with('status', '投稿を更新しました！');
}
    public function destroy(Post $post)
    {
       // Breeze 生成の UserPolicy を利用
        $post->delete();

        return redirect()->route('posts.index')->with('status', '削除しました');
    }

    public function __construct()
{
    $this->middleware('auth');
    $this->authorizeResource(Post::class, 'post');
}
}


@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold">投稿編集</h1>
@endsection

@section('content')
<div class="w-96 mx-auto">
    <form action="{{ route('posts.update', $post) }}" method="POST" class="space-y-6">
      @method('PUT')
      @csrf

        <div class="flex flex-col">
            <label for="title" class="mb-1 font-semibold">タイトル</label>
                       <input type="text" name="title" id="title"
                   value="{{ old('title', $post->title) }}"
                   class="border rounded-md px-3 py-2 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="flex flex-col">
            <label for="body" class="mb-1 font-semibold">内容</label>
                       <textarea name="body" id="body" rows="6"
                      class="border rounded-md px-3 py-2 bg-white text-gray-900 resize-y focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('body', $post->body) }}</textarea>

        <button type="submit"class="w-full px-4 py-2 bg-indigo-6000 hover:bg-indigo-700 text-white rounded-md">
            更新
        </button>
        </form>
        </div>

@endsection

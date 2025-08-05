@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold">掲示板一覧</h1>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('posts.create') }}"
       class="inline-block mb-6 px-4 py-2 bg-indigo-400 hover:bg-indigo-500
              text-white font-medium rounded-md transition-colors">
        新規投稿
    </a>

    <div class="space-y-6">
        @foreach ($posts as $post)
             <article class="bg-gray-800 p-4 rounded-md shadow">
                <p class="mt-1 text-sm text-gray-400">
                    投稿者: {{ optional($post->user)->name ?? 'Unknown' }} /
               {{ optional($post->created_at)->format('Y-m-d H:i') ?? '未設定' }}
                    @if ($post->updated_at && $post->updated_at->ne($post->created_at))
                        <span class="ml-2 px-2 py-0.5 bg-indigo-600/40 text-xs rounded">
                            編集済み
                        </span>
                    @endif
                </p>
            
                <h2 class="text-xl font-semibold text-gray-100">
                    {{ $post->title }}
                </h2>
                <p class="mt-2 text-gray-300">
                    {{ $post->body }}
                </p>
                @auth
                    @if (auth()->id() === $post->user_id)
                        <div class="flex space-x-2 mt-4">
                            <a href="{{ route('posts.edit', $post) }}"
                               class="px-2 py-0.5 text-sm bg-indigo-400 hover:bg-indigo-500 text-white rounded-md transition-colors">
                                編集
                            </a>

                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                  onsubmit="return confirm('本当に削除しますか？');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-2 py-0.5 text-sm bg-indigo-400 hover:bg-indigo-500 text-white rounded-md transition-colors">
                                    削除
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </article>
        @endforeach
        <div class="mt-6">
        {{ $posts->links() }}
    </div>
    </div>
</div>
@endsection
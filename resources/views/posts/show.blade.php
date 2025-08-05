{{-- resources/views/posts/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
    <p class="mb-4 whitespace-pre-wrap">{{ $post->body }}</p>

    <p class="text-sm text-gray-500">
        投稿者: {{ optional($post->user)->name ?? 'Unknown' }}<br>
        投稿日時: {{ optional($post->created_at)->format('Y-m-d H:i') ?? '未設定' }}
    </p>
</div>
@endsection
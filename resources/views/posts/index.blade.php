@extends('layouts.layout')

@section('content')


@include('posts._header')

<main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">

    @if($posts->count())
        @include('layouts.posts-grid', ['post' => $posts])
    @else
        <p class="text-center">No posts yet. Please check later.</p>
    @endif
</main>

@endsection

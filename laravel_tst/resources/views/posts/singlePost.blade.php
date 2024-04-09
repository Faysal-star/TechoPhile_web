@extends('layouts.user')

@section('title' , 'Post')

@section('contents')

{{-- <x-post-component :post="$post" /> --}}
<div class="postCard">
    <h3>
        <a href="/post/{{$post->id}}">{{$post->title}}</a>
    </h3>
    <p>{{$post->user->name}}</p>
    <x-post-tag :tagsCsv="$post->tags" />
    <div>
        {!! $post->body !!}
    </div>
</div>

@endsection
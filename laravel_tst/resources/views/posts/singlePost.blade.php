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
<form action="/comment" method="post">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <input type="text" name="body" id="body">
    <button>Submit</button>
</form>

<div class="comments">
@unless (count($comments) == 0)
    @foreach ($comments as $comment)
        {{-- <h2>Post</h2> --}}
        <x-comment :comment="$comment" />
    @endforeach
    
@else
    <p>No Comments yet</p>
@endunless
</div>
@endsection
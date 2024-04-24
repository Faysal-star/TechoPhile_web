@extends('layouts.user')

@section('title' , 'Home')

@section('contents')

<div class="mainHome">
    <div class="createPost">
        <div class="profile">
            @if (auth()->user()->profile->image)
                <img src="{{asset('storage/images/'.auth()->user()->profile->image)}}" alt="profile">
            @else
                <img src="{{asset('images/profile.jpg')}}" alt="profile">
            @endif
        </div> 
        <div class="postDesc">
            <p>Something you want to share ?....</p>
        </div>
        <div class="postBtn">
            <a href="/post/create">
                <i class="fas fa-plus"></i>
                Create Post
            </a>
        </div>
    </div>

    <div class="postSection">
        @unless (count($posts) == 0)
            @foreach ($posts as $post)
                {{-- <h2>Post</h2> --}}
                <x-post-component :post="$post" />
            @endforeach
            
        @else
            <p>No Posts</p>
        @endunless
    </div>

</div>

@endsection
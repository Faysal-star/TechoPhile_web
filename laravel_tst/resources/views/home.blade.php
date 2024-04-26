@extends('layouts.user')

@section('title' , 'Home')

@section('contents')

<div class="mainHome">
    <div class="search">
        <form action="/home">
            <input type="text" name="search" id="search" placeholder="Search post...">
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <div class="createPost">
        <div class="profile">
            <img src={{ auth()->user()->profile->avatar ? asset('storage/'.auth()->user()->profile->avatar) : asset('images/profile.jpg') }} />
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
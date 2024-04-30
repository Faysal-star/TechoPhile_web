@extends('layouts.user')

@section('title' , 'Post')

@section('CustomCss')
    <link rel="stylesheet" href="{{asset('css/posts/singlePost.css')}}">
@endsection

@section('contents')

<div class="mainPost">

    <div class="upperInfo">
        <div class="postTitle">
            <h1>{{$post->title}}</h1>
        </div>
        <div class="postInfo">
            {{-- <img src="./images/profile.jpg" alt=""> --}}
            <img src={{ $post->user->profile->avatar ? asset('storage/'.$post->user->profile->avatar) : asset('images/profile.jpg') }} alt="">
            <div class="authorInfo">
                <span><a href="/profile/{{$post->user->profile->id}}">{{$post->user->name}}</a></span>
                <br>
                <span class="date">{{$post->created_at}}</span>
            </div>
        </div>
        <div class="hashTags">
            @php
                $tags = explode(',' , $post->tags)
            @endphp
            @foreach ($tags as $tag)
                <a href="/home/?tag={{$tag}}" class="tag">{{$tag}}</a>
            @endforeach
        </div>
    </div>

    <div class="postContent" id="blogText">
        {!!$post->body !!}
        {{-- <img src="./images/cover.jpg" alt=""> --}}
    </div>

    <div class="counts">
        <form action="/post/{{$post->id}}/like" method="post" class="likeForm">
            @csrf
            <button class="likeBtn {{$liked ? 'cyanCnt' : ''}}" >
                <i class="fas fa-heart"></i>
                {{$post->likes->count()}}
            </button>
        </form>
        <form action="/post/{{$post->id}}/dislike" method="post" class="dislikeForm">
            @csrf
            <button class="dislikeBtn {{$disliked ? 'redCnt' : ''}}">
                <i class="fas fa-heart-broken"></i>
                {{$post->dislikes->count()}}
            </button>
        </form>
        <div class="commentCnt">
            <button>
                <i class="fa-regular fa-comment"></i>
                {{$post->comment->count()}}
            </button>
        </div>
        <div class="report">
            <a href="/report/{{$post->id}}">
                <button>
                <i class="fas fa-flag"></i>
                Report
            </button>
        </a>
        </div>
    </div>

    <div class="factCheck">
        <h2 >Fact Check</h2>
        <p id='factCheckResult'>Click to Fact Check</p>
    </div>

    <div class="postComment">
        <form action="/comment" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="text" name="body" id="body" placeholder="Write Your Comment...">
            <button type="submit">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
    
    

    <div class="prevComments">
        @unless (count($comments) == 0)
        @foreach ($comments as $comment)
            {{-- <h2>Post</h2> --}}
            <x-comment :comment="$comment" />
        @endforeach
        
        @else
            <p>No Comments yet</p>
        @endunless
    </div>
</div>


<script src="{{asset('js/singlePost.js')}}"></script>

@endsection
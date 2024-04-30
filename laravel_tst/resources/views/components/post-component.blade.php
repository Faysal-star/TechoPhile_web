@props(['post'])

<div class="post">
    <div class="postHeader">
        <div class="proPic">
            <img src={{ $post->user->profile->avatar ? asset('storage/'.$post->user->profile->avatar) : asset('images/profile.jpg') }} alt="profile">
        </div>
        <div class="otherDetails">
            <p class="nameP">
                <a href="/profile/{{$post->user->profile->id}}">{{$post->user->name}}</a>
            </p>
            <p class="time">{{$post->created_at}}</p>
        </div>
    </div>
    <div class="postContent">
        {{-- <a href="/" class="postTitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, reiciendis.</a> --}}
        <a href="/post/{{$post->id}}" class="postTitle">{{$post->title}}</a>
    </div>
    <div class="postFooter">
        <div class="tags">
            @php
                $tags = explode(',' , $post->tags)
            @endphp
            @foreach ($tags as $tag)
                <a href="/home/?tag={{$tag}}" class="tag">{{$tag}}</a>
            @endforeach
        </div>
        <div class="counts">
            <button class="likeBtn">
                <i class="fas fa-heart"></i>
                {{$post->likes->count()}}
            </button>
            <button class="dislikeBtn">
                <i class="fas fa-heart-broken"></i>
                {{$post->dislikes->count()}}
            </button>
            <div class="commentCnt">
                <button>
                    <i class="fa-regular fa-comment"></i>
                    {{$post->comment->count()}}
                </button>
            </div>
        </div>
    </div>
</div>
@props(['post'])

<div class="postCard">
    <h3>
        <a href="/post/{{$post->id}}">{{$post->title}}</a>
    </h3>
    <x-post-tag :tagsCsv="$post->tags"/>
    <p>
        {{$post->body}}
    </p>
</div>
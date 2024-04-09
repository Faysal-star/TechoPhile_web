@props(['comment'])

<div class="singleComment">
    <h3>{{$comment->user->name}}</h3>
    <p>{{$comment->body}}</p>
</div>
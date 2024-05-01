@props(['comment'])

{{-- <div class="singleComment">
    <h3>{{$comment->user->name}}</h3>
    <p>{{$comment->body}}</p>
</div> --}}

<div class="cmntWithReply">
    <div class="comment">
        <div class="cmntAuthor">
            {{-- <img src="./images/profile.jpg" alt=""> --}}
            <img src={{ $comment->user->profile->avatar ? asset('storage/'.$comment->user->profile->avatar) : asset('images/profile.jpg') }} alt="profile">
            <div class="cmntAthr">
                <a href="#">{{$comment->user->name}}</a>
                <p>
                    {{$comment->created_at}}
                </p>
            </div>
        </div>
        <div class="cmntContent">
            <p>{{$comment->body}}</p>
        </div>
        <div class="replyForm">
            <div class="replyShow">Reply</div>
            <form action="/comment" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{$comment->user->id}}">
                <input type="hidden" name="post_id" value="{{$comment->post_id}}">
                <input type="hidden" name="parent_id" value="{{$comment->id}}">
                <input type="text" name="body" placeholder="Reply...">
                <button type="submit"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
    @if(count($comment->replies) > 0)
        <div class="replies">
            @foreach ($comment->replies as $reply)
                <x-comment :comment="$reply"/>
            @endforeach
        </div>
    @endif
</div>
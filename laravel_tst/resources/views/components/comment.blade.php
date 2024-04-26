@props(['comment'])

{{-- <div class="singleComment">
    <h3>{{$comment->user->name}}</h3>
    <p>{{$comment->body}}</p>
</div> --}}

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
</div>
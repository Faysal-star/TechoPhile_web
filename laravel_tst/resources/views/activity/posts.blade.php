@extends('layouts.user')

@section('title' , 'My Posts')

@section('CustomCss')
    <link rel="stylesheet" href="{{asset('css/activity.css')}}">
@endsection

@section('contents')
<div class="activityMain">
    <h3>Activity Log </h3>
    <div class="grps">
        <div class="leftActivity">
            <div class="activityGrpL">
                <a href="/activity/likes">Likes</a>
            </div>
            <div class="activityGrpL">
                <a href="/activity/dislikes">Dislikes</a>
            </div>
            <div class="activityGrpL active">
                <a href="/activity/posts">Posts</a>
            </div>
            <div class="activityGrpL">
                <a href="/activity/notifications">Notifications</a>
            </div>
        </div>
        <div class="rightActivity">
            @unless (count($posts) > 0)
                <div class="activityGrpR">
                    <p>No posts yet</p>
                </div>
                
            @else
                @foreach ($posts as $post)
                    <div class="activityGrpR">
                        You posted on {{$post->created_at->format('d M Y')}}
                        <br>
                        Title : {{$post->title}}
                        <div class="editGrp">
                            <button class="view">
                                <a href="/post/{{$post->id}}">View</a>
                            </button>
                            <button class="editBtn">
                                <a href="/post/{{$post->id}}/edit">Edit</a>
                            </button>
                            <form id="deleteForm" method="POST" action="/post/{{$post->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="deleteBtn"  onclick="confirmDelete()">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endunless
            
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        var userInput = prompt("Please type 'delete' to confirm:");

        if (userInput === 'delete') {
            document.getElementById('deleteForm').submit();
        } else {
            alert("Deletion cancelled. You did not type 'delete'.");
        }
    }
</script>

@endsection
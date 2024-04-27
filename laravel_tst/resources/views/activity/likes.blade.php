@extends('layouts.user')

@section('title' , 'Likes')

@section('CustomCss')
    <link rel="stylesheet" href="{{asset('css/activity.css')}}">
@endsection

@section('contents')
<div class="activityMain">
    <h3>Activity Log </h3>
    <div class="grps">
        <div class="leftActivity">
            <div class="activityGrpL active">
                <a href="/activity/likes">Likes</a>
            </div>
            <div class="activityGrpL">
                <a href="/activity/dislikes">Dislikes</a>
            </div>
            <div class="activityGrpL">
                <a href="/activity/posts">Posts</a>
            </div>
        </div>
        <div class="rightActivity">
            @unless (count($likes) > 0)
                <div class="activityGrpR">
                    <p>No likes yet</p>
                </div>
                
            @else
                @foreach ($likes as $like)
                    <div class="activityGrpR">
                        You disliked post of {{$like->user->name}} on {{$like->created_at->format('d M Y')}}
                        <br>
                        Title : {{$like->title}}
                        <div class="goBtn">
                            <a href="/post/{{$like->id}}"><button class="goBtnR">Go</button></a>
                        </div>
                    </div>
                @endforeach
            @endunless
            
        </div>
    </div>
</div>

@endsection
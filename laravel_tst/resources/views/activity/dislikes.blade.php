@extends('layouts.user')

@section('title' , 'Dislikes')

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
            <div class="activityGrpL active">
                <a href="/activity/dislikes">Dislikes</a>
            </div>
            <div class="activityGrpL">
                <a href="/activity/posts">Posts</a>
            </div>
        </div>
        <div class="rightActivity">
            @unless (count($dislikes) > 0)
                <div class="activityGrpR">
                    <p>No dislikes yet</p>
                </div>
                
            @else
                @foreach ($dislikes as $dislike)
                    <div class="activityGrpR">
                        You liked post of {{$dislike->user->name}} on {{$dislike->created_at->format('d M Y')}}
                        <br>
                        Title : {{$dislike->title}}
                        <div class="goBtn">
                            <a href="/post/{{$dislike->id}}"><button class="goBtnR">Go</button></a>
                        </div>
                    </div>
                @endforeach
            @endunless
            
        </div>
    </div>
</div>

@endsection
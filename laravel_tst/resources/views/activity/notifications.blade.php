@extends('layouts.user')

@section('title' , 'Notifications')

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
            <div class="activityGrpL">
                <a href="/activity/posts">Posts</a>
            </div>
            <div class="activityGrpL active">
                <a href="/activity/notifications">Notifications</a>
            </div>
        </div>
        <div class="rightActivity">
            @unless (count($notifications) > 0)
                <div class="activityGrpR">
                    <p>No likes yet</p>
                </div>
                
            @else
                @foreach ($notifications as $notification)
                    @if($notification['type'] == 'report')
                        <div class="activityGrpR">
                            {!! $notification['message'] !!}
                        </div>
                    @else
                        <div class="activityGrpR">
                            <p> {!! $notification['message'] !!} </p>
                            <br>
                            {{-- Title : {{$like->title}} --}}
                            <div class="goBtn">
                                <a href="/post/{{$notification['post_id']}}"><button class="goBtnR">Go</button></a>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endunless
            
        </div>
    </div>
</div>

@endsection
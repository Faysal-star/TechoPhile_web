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
                <a href="/followPage/followers">Followers</a>
            </div>
            <div class="activityGrpL">
                <a href="/followPage/followings">Followings</a>
            </div>
        </div>
        <div class="rightActivity">
            @unless (count($profiles) > 0)
                <div class="activityGrpR">
                    <p>No Followers yet</p>
                </div>
                
            @else
                @foreach ($profiles as $profile)
                    <div class="activityGrpR profileP">
                        <img src={{ $profile->avatar ? asset('storage/'.$profile->avatar) : asset('images/profile.jpg') }} alt="profile">
                        <a href="/profile/{{$profile->id}}">{{$profile->user->name}}</a>
                    </div>
                @endforeach
            @endunless
            
        </div>
    </div>
</div>

@endsection
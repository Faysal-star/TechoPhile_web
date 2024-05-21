@extends('layouts.user')

@section('title' , 'Reports')

@section('CustomCss')
    <link rel="stylesheet" href="{{asset('css/activity.css')}}">
@endsection

@section('contents')

@if($authUser->type == 'user')
    <div class="activityMain">
        <p>You Are Not Admin</p>
    </div>  
@endif

@endsection
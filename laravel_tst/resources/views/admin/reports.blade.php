@extends('layouts.user')

@section('title' , 'My Posts')

@section('CustomCss')
    <link rel="stylesheet" href="{{asset('css/activity.css')}}">
@endsection

@section('contents')

@if($authUser->type == 'user')
    <div class="activityMain">
        <p>You Are Not Admin</p>
    </div>  
@else

<div class="activityMain">
    <h3>Activity Log </h3>
    <div class="grps">
        <div class="leftActivity">
            <div class="activityGrpL active">
                <a href="/admin/reports">Reports</a>
            </div>
            <div class="activityGrpL">
                <a href="/admin/rooms">Chat Room</a>
            </div>
            <div class="activityGrpL">
                <a href="/admin/hiring">Hiring</a>
            </div>
        </div>
        <div class="rightActivity">
            @unless (count($reports) > 0)
                <div class="activityGrpR">
                    <p>No reports yet</p>
                </div>
                
            @else
                @foreach ($reports as $report)
                    <div class="activityGrpR">
                        {{$report['user']}} Reported This post on {{$report['created_at']->format('d M Y')}}
                        <br>
                        Title : {{$report['post']}}
                        <br>
                        Reason : {{$report['reason']}}
                        <br>
                        Report Count : {{$report['count']}}
                        <div class="editGrp">
                            <button class="view">
                                <a href="/post/{{$report['post_id']}}">View</a>
                            </button>
                            <form method="POST" action="/admin/delete/{{$report['post_id']}}">
                                @csrf
                                @method('DELETE')
                                <button class="deleteBtn">
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

@endif
@endsection
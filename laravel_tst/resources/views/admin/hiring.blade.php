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
    <h3>Admin Panel </h3>
    <div class="grps">
        <div class="leftActivity">
            <div class="activityGrpL">
                <a href="/admin/reports">Reports</a>
            </div>
            <div class="activityGrpL">
                <a href="/admin/rooms">Chat Room</a>
            </div>
            @if($authUser->type == 'superAdmin')
                <div class="activityGrpL active">
                    <a href="/admin/hiring">Hiring</a>
                </div>
            @endif
        </div>
        <div class="rightActivity">
            @unless(count($admins) > 0)
                <div class="activityGrpR">
                    <p>No Admins yet</p>
                </div>
            @else
                @foreach ($admins as $admin)
                    <div class="activityGrpR">
                        {{$admin->name}} is an Admin
                        <div class="editGrp">
                            <button class="view">
                                <a href="/profile/{{$admin->id}}">View</a>
                            </button>
                            <form id="removeForm" method="POST" action="/admin/remove/{{$admin->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="deleteBtn" onclick="confirmDelete2()">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endunless

            @unless (count($jobs) > 0)
                <div class="activityGrpR">
                    <p>No Job Applications yet</p>
                </div>
                
            @else
                @foreach ($jobs as $job)
                    <div class="activityGrpR">
                        {{$job['user']}} Applied for the job on {{$job['created_at']->format('d M Y')}}
                        <br>
                        Application : {{$job['msg']}}
                        <div class="editGrp">
                            <button class="view">
                                <a href="/profile/{{$job['profile']}}">View</a>
                            </button>
                            <form id="approveForm" method="POST" action="/admin/approve/{{$job['id']}}">
                                @csrf
                                <button type="button" class="approveBtn" onclick="confirmApprove()">
                                    Approve
                                </button>
                            </form>
                            <form id="deleteForm" method="POST" action="/admin/reject/{{$job['id']}}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="deleteBtn"  onclick="confirmDelete()">
                                    Reject
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
    function confirmApprove() {
        var userInput = prompt("Please type 'approve' to confirm:");

        if (userInput === 'approve') {
            document.getElementById('approveForm').submit();
        } else {
            alert("Cancled. You did not type 'approve'");
        }
    }
    function confirmDelete() {
        var userInput = prompt("Please type 'delete' to confirm:");

        if (userInput === 'delete') {
            document.getElementById('deleteForm').submit();
        } else {
            alert("Deletion cancelled. You did not type 'delete'.");
        }
    }
    function confirmDelete2(){
        var userInput = prompt("Please type 'delete' to confirm:");

        if (userInput === 'delete') {
            document.getElementById('removeForm').submit();
        } else {
            alert("Deletion cancelled. You did not type 'delete'.");
        }

    }
</script>

@endif
@endsection
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
    <h3>Admin Panel</h3>
    <div class="grps">
        <div class="leftActivity">
            <div class="activityGrpL">
                <a href="/admin/reports">Reports</a>
            </div>
            <div class="activityGrpL active">
                <a href="/admin/rooms">Chat Room</a>
            </div>
            <div class="activityGrpL">
                <a href="/admin/hiring">Hiring</a>
            </div>
        </div>
        <div class="rightActivity">
            <div class="addRoomDiv activityGrpR ">
                <form action="/admin/addRoom" method="POST">
                    @csrf
                    <input type="text" name="room_name" placeholder="Enter Room Name" required>
                    @error('room_name')
                        <p>{{$message}}</p>
                    @enderror
                    <input type="submit" value="Add Room" class="addRoomBtn">
                </form>
            </div>

            @unless (count($rooms) > 0)
                <div class="activityGrpR">
                    <p>No rooms yet</p>
                </div>
                
            @else
                @foreach ($rooms as $room)
                    <div class="activityGrpR">
                        Room : {{$room->room_name}}
                        <br>
                        Created at : {{$room->created_at->format('d M Y')}} 
                        <div class="editGrp">
                            <form id="deleteForm" method="POST" action="/admin/room/delete/{{$room->id}}">
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

@endif
@endsection
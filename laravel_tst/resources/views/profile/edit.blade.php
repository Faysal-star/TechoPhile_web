@extends('layouts.user')

@section('title' , 'Edit Profile')

@section('CustomCss')
    <link rel="stylesheet" href="{{asset('css/profile/editProfile.css')}}">
@endsection

@section('contents')
<div class="mainEdit">
    <h2>Edit your profile <span class="eColor">Mr. Name</span></h2>
    <div class="edit">
        <form action="/profile/{{$profile->id}}" method="POST" class="editForm" enctype="multipart/form-data" >
            @csrf
            @method('PUT')

            <div class="grp">
                <input type="text" name="name" id="name" placeholder="Name" value="{{$profile->name}}">
                <input type="text" name="phone" id="phone"placeholder="Phone" value="{{$profile->phone}}" >
            </div>
            
            <input type="text" name="bio" id="bio" placeholder="Bio" value="{{$profile->bio}}">
            
            <div class="grp">
                <input type="text" name="address" id="address"placeholder="Address" value="{{$profile->address}}">
                <input type="text" name="city" id="city" placeholder="City" value="{{$profile->city}}">
            </div>
            
            <div class="github grp">
                <input type="text" name="github" id="github"placeholder="Github Username" value="{{$profile->github}}">
                <input type="text" name="github_link" id="github_link"placeholder="Github Link" value="{{$profile->github_link}}">
            </div>
            
            <div class="linkedin grp">
                <input type="text" name="linkedin" id="linkedin" placeholder="Linkedin Username" value="{{$profile->linkedin}}">
                <input type="text" name="linkedin_link"id="linkedin_link" placeholder="Linkedin Link" value="{{$profile->linkedin_link}}">
            </div>
            
            <div class="twitter grp">
                <input type="text" name="twitter" id="twitter"placeholder="Twitter Username" value="{{$profile->twitter}}">
                <input type="text" name="twitter_link" id="twitter_link"placeholder="Twitter Link" value="{{$profile->twitter_link}}">
            </div>
            
            <div class="facebook grp">
                <input type="text" name="facebook" id="facebook"placeholder="Facebook Username" value="{{$profile->facebook}}">
                <input type="text" name="facebook_link"id="facebook_link" placeholder="Facebook Link" value="{{$profile->facebook_link}}">
            </div>

            <div class="filegrp grp">
                <div class="avatar">
                    <label for="avatar">Avatar</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*">
                </div>
                <div class="cover">
                    <label for="cover">Cover</label>
                    <input type="file" name="cover" id="cover" accept="image/*">
                </div>
            </div>
            
            <button type="submit" class="formSubmit">Update</button>
        </form>
    </div>
</div>

@endsection
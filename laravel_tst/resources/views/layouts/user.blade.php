<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="shortcut icon" href="{{asset('images/app_logo.png')}}" type="image/x-icon">
    <title>@yield('title')</title>
    @yield('CustomCss')
</head>
<body>
    <nav>
        <div class="logo">
            <img src="{{asset('images/app_logo.png')}}" alt="">
            <h2>Techo<span class="colored">Phile</span></h2>
        </div>
        <div class="menu">
            <ul>
                <li>
                    <a href="/home">
                        <i class="fas fa-home"></i>
                        <p class="ltext">Home</p>
                    </a>
                </li>
                <li>
                    <a href="/followPage">
                        <i class="fas fa-user-friends"></i>
                        <p class="ltext">Follow</p>
                    </a>
                </li>
                <li>
                    <a href="/chatLogin">
                        <i class="fas fa-comment-alt"></i>
                        <p class="ltext">Chat</p>
                    </a>
                </li>
                <li>
                    <a href="/activity">
                        <i class="fas fa-bell"></i>
                        <p class="ltext">Activity</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="me">
            <a href="/profile/{{auth()->user()->profile->id}}">{{auth()->user()->name}}</a>
            {{-- <img src="./images/profile.jpg" alt=""> --}}
            <img src={{ auth()->user()->profile->avatar ? asset('storage/'.auth()->user()->profile->avatar) : asset('images/profile.jpg') }} alt="profile">
        </div>
    </nav>

    @yield('contents')

</body>
</html>
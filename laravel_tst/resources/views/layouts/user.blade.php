<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/user.css')}}">
</head>
<body>
    <div class="whole">
        <nav>
            <h2>Welcome {{auth()->user()->name}}</h2>
            @if(auth()->user()->type == 'user') 
                <h3>You can't view this bro</h3>
            @else
                <h3>Admin panel</h3>
            @endif
        </nav>

        <main>
            @yield('contents')
        </main>
    </div>
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>@yield('titel', 'Autobeheer')</title>
</head>
<body class="bg-light">

    <!-- Navigatiebalk -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('cars.index') }}">🚗 AutoMarkt</a>
            <div>
                <a href="{{ route('cars.index') }}" class="btn btn-outline-light btn-sm me-2">Publiek Aanbod</a>
                @auth
                <a href="{{ route('admin.cars.index') }}" class="btn btn-warning btn-sm">Admin Beheer</a>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-info btn-sm">Reserveringen Beheer</a>

                <form method="post" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        Uitloggen {{auth()->user()->name}}
                    </button>
                </form>
                @endauth
                @guest
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Log in</a>
                @endguest
            </div>
        </div>
    </nav>


    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>

    
</body>
</html>
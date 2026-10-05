<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Carrito Laravel')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header class="site-header">
    <div class="container nav">
        <a class="brand" href="{{ auth()->check() ? route('productos.index') : route('login') }}">Carrito Laravel</a>
        @auth
            <nav class="nav-links">
                <a href="{{ route('productos.index') }}">Productos</a>
                <a href="{{ route('carrito.index') }}">Carrito</a>
                <a href="{{ route('pedidos.index') }}">Mis pedidos</a>
                <span class="user-name">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="link-button" type="submit">Salir</button>
                </form>
            </nav>
        @endauth
    </div>
</header>

<main class="container main-content">
    @if (session('status'))
        <div class="alert success">{{ session('status') }}</div>
    @endif

    @if (session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>

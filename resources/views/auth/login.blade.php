@extends('layouts.plantilla')

@section('title', 'Iniciar sesión')

@section('content')
<div class="auth-card">
    <h1>Iniciar sesión</h1>
    <p class="muted">Accede para consultar el catálogo y gestionar tu carrito.</p>

    <form action="{{ route('login.store') }}" method="POST" class="form-stack">
        @csrf
        <label>
            Correo electrónico
            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
        </label>
        <label>
            Contraseña
            <input type="password" name="password" required autocomplete="current-password">
        </label>
        <label class="checkbox-row">
            <input type="checkbox" name="remember" value="1">
            Recordarme
        </label>
        <button class="btn primary" type="submit">Entrar</button>
    </form>

    <p class="auth-footer">¿No tienes cuenta? <a href="{{ route('register') }}">Crear cuenta</a></p>
</div>
@endsection

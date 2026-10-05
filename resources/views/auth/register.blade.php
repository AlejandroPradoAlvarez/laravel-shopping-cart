@extends('layouts.plantilla')

@section('title', 'Crear cuenta')

@section('content')
<div class="auth-card">
    <h1>Crear cuenta</h1>
    <p class="muted">Regístrate para probar el flujo completo de compra.</p>

    <form action="{{ route('register.store') }}" method="POST" class="form-stack">
        @csrf
        <label>
            Nombre
            <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
        </label>
        <label>
            Correo electrónico
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
        </label>
        <label>
            Contraseña
            <input type="password" name="password" required autocomplete="new-password">
        </label>
        <label>
            Repetir contraseña
            <input type="password" name="password_confirmation" required autocomplete="new-password">
        </label>
        <button class="btn primary" type="submit">Registrarme</button>
    </form>

    <p class="auth-footer">¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></p>
</div>
@endsection

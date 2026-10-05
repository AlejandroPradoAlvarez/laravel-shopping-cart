@extends('layouts.plantilla')

@section('title', 'Catálogo')

@section('content')
<section class="page-heading">
    <div>
        <p class="eyebrow">Catálogo</p>
        <h1>Productos disponibles</h1>
        <p class="muted">Ejemplo de catálogo con carrito persistido en sesión y control de stock.</p>
    </div>
    <a class="btn secondary" href="{{ route('carrito.index') }}">Ver carrito</a>
</section>

<div class="product-grid">
    @forelse ($productos as $producto)
        <article class="product-card">
            <div class="product-visual">{{ strtoupper(substr($producto->nombre, 0, 1)) }}</div>
            <div class="product-body">
                <div class="product-meta">
                    <h2>{{ $producto->nombre }}</h2>
                    <span class="stock {{ $producto->stock === 0 ? 'out' : '' }}">Stock: {{ $producto->stock }}</span>
                </div>
                <p>{{ $producto->descripcion }}</p>
                <div class="product-footer">
                    <strong>{{ number_format((float) $producto->precio, 2, ',', '.') }} €</strong>
                    <form action="{{ route('carrito.store', $producto) }}" method="POST">
                        @csrf
                        <button class="btn primary" type="submit" @disabled($producto->stock === 0)>
                            {{ $producto->stock === 0 ? 'Agotado' : 'Añadir' }}
                        </button>
                    </form>
                </div>
            </div>
        </article>
    @empty
        <p>No hay productos disponibles.</p>
    @endforelse
</div>
@endsection

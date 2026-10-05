@extends('layouts.plantilla')

@section('title', 'Carrito')

@section('content')
<section class="page-heading">
    <div>
        <p class="eyebrow">Compra</p>
        <h1>Tu carrito</h1>
        <p class="muted">Actualiza cantidades, elimina productos o confirma el pedido.</p>
    </div>
    <a class="btn secondary" href="{{ route('productos.index') }}">Seguir comprando</a>
</section>

@if ($carrito->isEmpty())
    <div class="empty-state">
        <h2>El carrito está vacío</h2>
        <p class="muted">Añade algún producto desde el catálogo para continuar.</p>
        <a class="btn primary" href="{{ route('productos.index') }}">Ir al catálogo</a>
    </div>
@else
    <div class="cart-layout">
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carrito as $linea)
                        <tr>
                            <td><strong>{{ $linea['nombre'] }}</strong></td>
                            <td>{{ number_format($linea['precio'], 2, ',', '.') }} €</td>
                            <td>
                                <form class="quantity-form" action="{{ route('carrito.update', $linea['id']) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="cantidad" min="1" value="{{ $linea['cantidad'] }}" required>
                                    <button class="btn small secondary" type="submit">Actualizar</button>
                                </form>
                            </td>
                            <td>{{ number_format($linea['subtotal'], 2, ',', '.') }} €</td>
                            <td>
                                <form action="{{ route('carrito.destroy', $linea['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn small danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <aside class="summary-card">
            <h2>Resumen</h2>
            <div class="summary-row total">
                <span>Total</span>
                <strong>{{ number_format($total, 2, ',', '.') }} €</strong>
            </div>
            <form action="{{ route('pedidos.store') }}" method="POST">
                @csrf
                <button class="btn primary full" type="submit">Confirmar pedido</button>
            </form>
            <form action="{{ route('carrito.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn ghost full" type="submit">Vaciar carrito</button>
            </form>
        </aside>
    </div>
@endif
@endsection

@extends('layouts.plantilla')

@section('title', 'Pedido #'.$pedido->id)

@section('content')
<section class="page-heading">
    <div>
        <p class="eyebrow">Pedido confirmado</p>
        <h1>Pedido #{{ $pedido->id }}</h1>
        <p class="muted">Realizado el {{ $pedido->fecha->format('d/m/Y') }}.</p>
    </div>
    <a class="btn secondary" href="{{ route('pedidos.index') }}">Volver al historial</a>
</section>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedido->productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ number_format((float) $producto->pivot->precio_unitario, 2, ',', '.') }} €</td>
                    <td>{{ $producto->pivot->cantidad }}</td>
                    <td>{{ number_format((float) $producto->pivot->subtotal, 2, ',', '.') }} €</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th>{{ number_format((float) $pedido->total, 2, ',', '.') }} €</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

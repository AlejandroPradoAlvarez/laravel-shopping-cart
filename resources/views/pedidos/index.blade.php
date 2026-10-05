@extends('layouts.plantilla')

@section('title', 'Mis pedidos')

@section('content')
<section class="page-heading">
    <div>
        <p class="eyebrow">Historial</p>
        <h1>Mis pedidos</h1>
        <p class="muted">Pedidos guardados en base de datos con sus productos y precios históricos.</p>
    </div>
</section>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Pedido</th>
                <th>Fecha</th>
                <th>Productos</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pedidos as $pedido)
                <tr>
                    <td>#{{ $pedido->id }}</td>
                    <td>{{ $pedido->fecha->format('d/m/Y') }}</td>
                    <td>{{ $pedido->productos_count }}</td>
                    <td>{{ number_format((float) $pedido->total, 2, ',', '.') }} €</td>
                    <td><a href="{{ route('pedidos.show', $pedido) }}">Ver detalle</a></td>
                </tr>
            @empty
                <tr><td colspan="5">Todavía no has realizado ningún pedido.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

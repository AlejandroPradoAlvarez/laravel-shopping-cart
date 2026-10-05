<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function index(Request $request): View
    {
        $pedidos = $request->user()
            ->pedidos()
            ->withCount('productos')
            ->latest()
            ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    public function show(Request $request, Pedido $pedido): View
    {
        abort_unless($pedido->user_id === $request->user()->id, 403);

        $pedido->load('productos');

        return view('pedidos.show', compact('pedido'));
    }

    public function store(Request $request): RedirectResponse
    {
        $carrito = collect($request->session()->get('carrito', []));

        if ($carrito->isEmpty()) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }

        $pedido = DB::transaction(function () use ($carrito, $request) {
            $productos = Producto::query()
                ->whereIn('id', $carrito->keys())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $detalle = [];

            foreach ($carrito as $productoId => $linea) {
                $producto = $productos->get((int) $productoId);
                $cantidad = (int) $linea['cantidad'];

                if (! $producto || $cantidad < 1 || $cantidad > $producto->stock) {
                    abort(422, 'El carrito contiene un producto sin stock suficiente.');
                }

                $precio = (float) $producto->precio;
                $subtotal = round($precio * $cantidad, 2);
                $total += $subtotal;

                $detalle[$producto->id] = [
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'subtotal' => $subtotal,
                ];

                $producto->decrement('stock', $cantidad);
            }

            $pedido = $request->user()->pedidos()->create([
                'fecha' => now()->toDateString(),
                'total' => round($total, 2),
            ]);

            $pedido->productos()->attach($detalle);

            return $pedido;
        });

        $request->session()->forget('carrito');

        return redirect()->route('pedidos.show', $pedido)->with('status', 'Pedido realizado correctamente.');
    }
}

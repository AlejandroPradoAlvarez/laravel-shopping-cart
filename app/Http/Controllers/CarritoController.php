<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarritoController extends Controller
{
    public function index(Request $request): View
    {
        $carrito = collect($request->session()->get('carrito', []));

        return view('carrito.index', [
            'carrito' => $carrito,
            'total' => $carrito->sum('subtotal'),
        ]);
    }

    public function store(Request $request, Producto $producto): RedirectResponse
    {
        $carrito = $request->session()->get('carrito', []);
        $cantidadActual = $carrito[$producto->id]['cantidad'] ?? 0;

        if ($cantidadActual >= $producto->stock) {
            return back()->with('error', 'No hay más unidades disponibles de este producto.');
        }

        $cantidad = $cantidadActual + 1;
        $carrito[$producto->id] = $this->lineaCarrito($producto, $cantidad);
        $request->session()->put('carrito', $carrito);

        return back()->with('status', 'Producto añadido al carrito.');
    }

    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $data = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1', 'max:'.$producto->stock],
        ]);

        $carrito = $request->session()->get('carrito', []);

        if (! isset($carrito[$producto->id])) {
            return redirect()->route('carrito.index')->with('error', 'El producto no está en el carrito.');
        }

        $carrito[$producto->id] = $this->lineaCarrito($producto, $data['cantidad']);
        $request->session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('status', 'Cantidad actualizada.');
    }

    public function destroy(Request $request, Producto $producto): RedirectResponse
    {
        $carrito = $request->session()->get('carrito', []);
        unset($carrito[$producto->id]);
        $request->session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('status', 'Producto eliminado del carrito.');
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget('carrito');

        return redirect()->route('carrito.index')->with('status', 'Carrito vaciado.');
    }

    private function lineaCarrito(Producto $producto, int $cantidad): array
    {
        $precio = (float) $producto->precio;

        return [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'subtotal' => round($precio * $cantidad, 2),
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function index(): View
    {
        return view('productos.index', [
            'productos' => Producto::query()->orderBy('nombre')->get(),
        ]);
    }
}

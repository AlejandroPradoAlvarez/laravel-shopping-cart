<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarritoTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_no_autenticado_no_puede_ver_el_carrito(): void
    {
        $response = $this->get(route('carrito.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_usuario_puede_anadir_un_producto_al_carrito(): void
    {
        $user = User::factory()->create();
        $producto = $this->crearProducto();

        $response = $this->actingAs($user)->post(route('carrito.store', $producto));

        $response->assertSessionHas('carrito.'.$producto->id.'.cantidad', 1);
        $response->assertSessionHas('carrito.'.$producto->id.'.subtotal', 25.5);
    }

    public function test_usuario_puede_actualizar_la_cantidad(): void
    {
        $user = User::factory()->create();
        $producto = $this->crearProducto();

        $this->actingAs($user)->post(route('carrito.store', $producto));
        $response = $this->actingAs($user)->patch(route('carrito.update', $producto), [
            'cantidad' => 3,
        ]);

        $response->assertRedirect(route('carrito.index'));
        $response->assertSessionHas('carrito.'.$producto->id.'.cantidad', 3);
        $response->assertSessionHas('carrito.'.$producto->id.'.subtotal', 76.5);
    }

    public function test_usuario_puede_eliminar_un_producto_del_carrito(): void
    {
        $user = User::factory()->create();
        $producto = $this->crearProducto();

        $this->actingAs($user)->post(route('carrito.store', $producto));
        $response = $this->actingAs($user)->delete(route('carrito.destroy', $producto));

        $response->assertSessionMissing('carrito.'.$producto->id);
    }

    public function test_confirmar_pedido_lo_guarda_descuenta_stock_y_vacia_carrito(): void
    {
        $user = User::factory()->create();
        $producto = $this->crearProducto(stock: 10);

        $this->actingAs($user)->post(route('carrito.store', $producto));
        $this->actingAs($user)->patch(route('carrito.update', $producto), ['cantidad' => 2]);
        $response = $this->actingAs($user)->post(route('pedidos.store'));

        $pedido = $user->pedidos()->first();

        $this->assertNotNull($pedido);
        $this->assertSame('51.00', $pedido->total);
        $this->assertSame(8, $producto->fresh()->stock);
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 2,
        ]);
        $response->assertRedirect(route('pedidos.show', $pedido));
        $response->assertSessionMissing('carrito');
    }

    private function crearProducto(int $stock = 5): Producto
    {
        return Producto::query()->create([
            'nombre' => 'Producto de prueba',
            'imagen' => null,
            'descripcion' => 'Descripción de prueba',
            'precio' => 25.50,
            'stock' => $stock,
        ]);
    }
}

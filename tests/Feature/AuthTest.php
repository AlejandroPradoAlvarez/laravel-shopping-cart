<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_registrarse(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Usuario Prueba',
            'email' => 'usuario@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('productos.index'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'usuario@example.com']);
    }

    public function test_usuario_puede_iniciar_sesion(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('productos.index'));
        $this->assertAuthenticatedAs($user);
    }
}

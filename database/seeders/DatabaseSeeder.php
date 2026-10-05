<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Usuario Demo',
                'password' => Hash::make('password'),
            ]
        );

        $productos = [
            ['nombre' => 'Teclado mecánico', 'descripcion' => 'Teclado compacto con interruptores mecánicos y conexión USB.', 'precio' => 79.90, 'stock' => 12],
            ['nombre' => 'Ratón inalámbrico', 'descripcion' => 'Ratón ergonómico de alta precisión con autonomía prolongada.', 'precio' => 34.50, 'stock' => 20],
            ['nombre' => 'Auriculares Bluetooth', 'descripcion' => 'Auriculares circumaurales con micrófono y conexión Bluetooth.', 'precio' => 59.99, 'stock' => 8],
            ['nombre' => 'Monitor 24 pulgadas', 'descripcion' => 'Monitor Full HD IPS pensado para trabajo, estudio y uso multimedia.', 'precio' => 149.00, 'stock' => 6],
            ['nombre' => 'Webcam Full HD', 'descripcion' => 'Cámara 1080p con micrófono integrado para reuniones y videollamadas.', 'precio' => 45.00, 'stock' => 15],
            ['nombre' => 'Hub USB-C', 'descripcion' => 'Adaptador multipuerto con HDMI, USB 3.0 y lector de tarjetas.', 'precio' => 39.95, 'stock' => 18],
        ];

        foreach ($productos as $producto) {
            Producto::query()->updateOrCreate(
                ['nombre' => $producto['nombre']],
                $producto + ['imagen' => null]
            );
        }
    }
}

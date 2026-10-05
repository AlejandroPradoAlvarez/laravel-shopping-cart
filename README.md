# Carrito Laravel

Aplicación web de comercio electrónico desarrollada con Laravel 10 como proyecto de portfolio. Incluye autenticación, catálogo de productos, carrito basado en sesión, control de stock y persistencia de pedidos mediante Eloquent.

## Funcionalidades

- Registro, inicio y cierre de sesión.
- Catálogo de productos almacenados en base de datos.
- Añadir productos al carrito.
- Modificar cantidades y eliminar líneas del carrito.
- Validación de stock antes de confirmar la compra.
- Creación de pedidos dentro de una transacción de base de datos.
- Relación muchos-a-muchos entre pedidos y productos con precio histórico, cantidad y subtotal.
- Historial y detalle de pedidos por usuario.
- Seeders con datos de demostración.
- Tests funcionales para los flujos principales.
- Interfaz responsive sin dependencias CSS externas.

## Tecnologías

- PHP 8.1+
- Laravel 10
- Eloquent ORM
- Blade
- MySQL / SQLite para tests
- PHPUnit
- Laravel Pint

## Modelo de datos

- `users`: usuarios registrados.
- `productos`: catálogo, precio y stock.
- `pedidos`: cabecera del pedido asociada a un usuario.
- `pedido_producto`: detalle del pedido con cantidad, precio unitario y subtotal.

## Instalación

```bash
git clone <URL_DEL_REPOSITORIO>
cd carrito-laravel
composer install
cp .env.example .env
php artisan key:generate
```

Configura las credenciales de base de datos en `.env` y ejecuta:

```bash
php artisan migrate --seed
php artisan serve
```

La aplicación estará disponible por defecto en `http://127.0.0.1:8000`.

## Usuario de demostración

Después de ejecutar los seeders:

- Email: `demo@example.com`
- Contraseña: `password`

También se puede crear un usuario nuevo desde la pantalla de registro.

## Tests

```bash
php artisan test
```

## Calidad de código

Para aplicar el formato estándar de Laravel:

```bash
./vendor/bin/pint
```

## Decisiones técnicas

El carrito se guarda en sesión para mantener una implementación sencilla y desacoplada de la base de datos hasta el momento de compra. Al confirmar el pedido, la aplicación vuelve a consultar los productos, bloquea las filas durante la transacción y valida el stock disponible antes de descontarlo y persistir el pedido. De esta forma, los precios y subtotales se calculan en servidor y no se confía en datos enviados desde el navegador.

## Mejoras futuras

- Panel de administración para gestionar productos.
- Subida de imágenes de producto.
- Paginación y buscador de catálogo.
- Pasarela de pago simulada o integración con Stripe en entorno de pruebas.
- API REST para catálogo y pedidos.

## Licencia

Proyecto de demostración para portfolio y aprendizaje.

# OrthoShoeFix — Gestión de órdenes

Sistema web para una zapatería de reparación y modificaciones ortopédicas en Michigan.
Stack: Laravel 13 · Livewire 4 · Flux (UI) · Tailwind 4 · MariaDB · Redis.

La interfaz está en inglés (los clientes son de Michigan); el código y esta documentación en español/inglés técnico.

## Roles

`users.role` es un enum (`App\Enums\UserRole`): `admin` (el zapatero) y `client` (el cliente).
El middleware alias `admin` (`App\Http\Middleware\EnsureUserIsAdmin`) protege el panel del taller.
`/dashboard` redirige según el rol, así que Fortify no necesita configuración extra.

## Rutas

| Ruta | Componente | Acceso |
|------|-----------|--------|
| `/` | `App\Livewire\Home` | público |
| `/orders` | `Client\Orders\Index` | cliente autenticado |
| `/orders/new` | `Client\Orders\Create` | cliente autenticado |
| `/orders/{order}` | `Client\Orders\Show` | dueño de la orden o admin |
| `/admin` | `Admin\Dashboard` | admin |
| `/admin/orders` | `Admin\Orders\Index` | admin |
| `/admin/orders/new` | `Admin\Orders\Create` | admin |
| `/admin/orders/{order}` | `Admin\Orders\Show` | admin |
| `/admin/customers` | `Admin\Customers\Index` | admin |

El área de cliente **no** exige `verified`: el taller da de alta clientes de mostrador y estos
deben poder seguir su orden de inmediato (el mailer está en `log`).

La autorización por orden vive en `App\Policies\OrderPolicy` (un cliente sólo ve sus órdenes;
sólo el taller actualiza precio, notas y estado).

## Modelo de datos

- **`orders`** — `order_number` (`OSF-26-0001`, secuencial por año), `user_id` (cliente),
  `created_by` (quien la registró, `null` si la mandó el cliente por la web), `service_type`,
  `shoe_type`, `description`, `status`, `estimated_price`, datos de contacto capturados en la orden,
  `received_at`, `estimated_delivery_at`, `ready_at`, `delivered_at`, `internal_notes`.
- **`order_status_events`** — historial: `from_status`, `to_status`, `changed_by`, `note`, `created_at`.
  Se escribe automáticamente al crear la orden y en cada `Order::markAs()`.
- **`order_photos`** — fotos de referencia en el disco `public` (`storage/app/public/order-photos`).
  El archivo se borra junto con el registro.

Enums: `OrderStatus` (`received → in_process → ready → delivered`, más `cancelled`),
`ServiceType` (reparación / modificación ortopédica / otro) y `ShoeType`.
Cada estado lleva su etiqueta, color, icono y posición en el pipeline, así que la UI no repite `match`.

## Flujos

**Cliente:** se registra (o lo registra el taller) → crea una solicitud con tipo de calzado,
descripción, hasta 5 fotos y datos de contacto → sigue el avance en `/orders/{order}`, que se
refresca con `wire:poll` cada 30 s y muestra un aviso verde cuando la orden está lista.
Al pasar a *ready* se le envía además el correo `OrderReadyForPickup`.

**Taller:** dashboard con órdenes activas, listas para entregar, entregadas del mes, ingresos del mes
y órdenes atrasadas → listado con filtros (búsqueda, estado, servicio, rango de fechas) y cambio de
estado rápido desde el menú de cada fila → detalle con historial, fotos, precio, fecha estimada y
notas internas → alta de clientes desde un modal (con contraseña temporal generada) → alta de
órdenes de mostrador.

Al crear una solicitud desde la web se notifica por correo a los administradores (`OrderSubmitted`).

## Puesta en marcha

```bash
docker compose exec app composer install
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
npm install && npm run build
```

Usuarios de demo que crea el seeder (contraseña `password` en ambos):

| Rol | Email |
|-----|-------|
| admin | `admin@orthoshoefix.com` |
| cliente | `customer@example.com` |

## Notas de desarrollo

- **`opcache.validate_timestamps=0`** en `php/Dockerfile`: PHP-FPM no relee los archivos
  modificados, así que después de cambiar código hay que reiniciar el contenedor:
  `docker compose restart app`.
- Al cambiar rutas o vistas con caché activa: `docker compose exec app php artisan optimize:clear`.
- Tailwind 4 escanea las vistas en build, así que después de tocar Blade: `npm run build`
  (o `npm run dev` para HMR).
- Pruebas y estilo: `docker compose exec app php artisan test` y `docker compose exec app ./vendor/bin/pint`.
  Las pruebas usan SQLite en memoria (`RefreshDatabase`), no tocan MariaDB.

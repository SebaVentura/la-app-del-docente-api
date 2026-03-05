# La App del Docente - API
Backend Laravel (API) para "La App del Docente". Fase 1: Auth + modelos base.

## Requisitos

- PHP 8.2+
- Composer
- MariaDB (o MySQL)
- Extensión PHP: pdo_mysql, mbstring, openssl, tokenizer, json

## Setup

### 1. Configurar base de datos

Editar `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=app_docente
DB_USERNAME=root
DB_PASSWORD=
```

Crear la base de datos en MariaDB:

```sql
CREATE DATABASE app_docente CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Migrar

```bash
php artisan migrate
```

### 3. Crear usuario de prueba (opcional)

```bash
php artisan tinker
```

En tinker:

```php
\App\Models\User::create([
    'name' => 'Docente Test',
    'email' => 'docente@test.com',
    'password' => bcrypt('password123'),
]);
```

### 4. Levantar servidor

```bash
php artisan serve
```

La API estará en `http://localhost:8000`.

## Endpoints (Fase 1)

| Método | Ruta        | Auth   | Descripción          |
|--------|-------------|--------|----------------------|
| POST   | /api/login  | No     | Login (email, password) |
| POST   | /api/logout | Sanctum | Cerrar sesión        |
| GET    | /api/me     | Sanctum | Usuario autenticado  |

## Probar con PowerShell (Invoke-RestMethod)

### Login

```powershell
$body = @{ email = "docente@test.com"; password = "password123" } | ConvertTo-Json
$resp = Invoke-RestMethod -Uri "http://localhost:8000/api/login" -Method Post -Body $body -ContentType "application/json"
$token = $resp.data.token
$token
```

### Me (con token)

```powershell
$headers = @{ Authorization = "Bearer $token"; Accept = "application/json" }
Invoke-RestMethod -Uri "http://localhost:8000/api/me" -Headers $headers
```

### Logout

```powershell
$headers = @{ Authorization = "Bearer $token" }
Invoke-RestMethod -Uri "http://localhost:8000/api/logout" -Method Post -Headers $headers
```

## Probar con curl

### Login

```bash
curl -X POST http://localhost:8000/api/login -H "Content-Type: application/json" -H "Accept: application/json" -d "{\"email\":\"docente@test.com\",\"password\":\"password123\"}"
```

### Me

```bash
curl -H "Authorization: Bearer TU_TOKEN" http://localhost:8000/api/me
```

### Logout

```bash
curl -X POST http://localhost:8000/api/logout -H "Authorization: Bearer TU_TOKEN"
```

## CORS

Permitido para `http://localhost:5173` (frontend Vite).

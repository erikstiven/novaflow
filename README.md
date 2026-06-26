# NovaFlow Surfaces

Sitio web corporativo de NovaFlow Surfaces, desarrollado con PHP y PHPMailer.

## Requisitos

- PHP 8.1 o superior
- Composer 2
- Extensiones PHP: `openssl`, `mbstring`
- Cuenta SMTP para el formulario de contacto

## Instalación local

1. Clonar el repositorio:

   ```bash
   git clone <URL_DEL_REPOSITORIO>
   cd novaflow
   ```

2. Instalar dependencias:

   ```bash
   composer install
   ```

3. Crear el archivo de entorno:

   **Windows (PowerShell):**

   ```powershell
   Copy-Item .env.example .env
   ```

   **Linux/macOS:**

   ```bash
   cp .env.example .env
   ```

4. Configurar `.env`:

   ```dotenv
   NOVAFLOW_SMTP_HOST=smtp.gmail.com
   NOVAFLOW_SMTP_PORT=587
   NOVAFLOW_SMTP_USER=correo@dominio.com
   NOVAFLOW_SMTP_PASS=clave_de_aplicacion
   ```

5. Levantar el servidor:

   ```bash
   php -S localhost:8000
   ```

6. Abrir `http://localhost:8000`.

## Configuración SMTP

- Usar una contraseña de aplicación; no la contraseña principal.
- Mantener `.env` fuera del control de versiones.
- Verificar que el proveedor permita SMTP con TLS en el puerto `587`.

El formulario envía las solicitudes a `novaflowsurfaces@gmail.com`.

## Despliegue

### Hosting compartido o cPanel

1. Subir el proyecto al directorio público del dominio.
2. Ejecutar localmente:

   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. Subir también el directorio `vendor`.
4. Crear `.env` directamente en el servidor.
5. Seleccionar PHP 8.1 o superior.
6. Habilitar `openssl` y `mbstring`.
7. Confirmar que `index.php` sea el archivo de entrada.
8. Confirmar que Apache permita las reglas de `.htaccess`.
9. Probar navegación, recursos estáticos y formulario SMTP.

### VPS con Apache o Nginx

1. Clonar el repositorio en el servidor.
2. Instalar dependencias:

   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. Crear y configurar `.env`.
4. Configurar el `DocumentRoot` o `root` hacia el directorio del proyecto.
5. Dar al usuario del servidor web permisos de lectura.
6. Configurar PHP-FPM si se utiliza Nginx.
7. Bloquear archivos sensibles en Nginx:

   ```nginx
   location ~ /\.(?!well-known) {
       deny all;
   }

   location ^~ /vendor/ {
       deny all;
   }
   ```

8. Activar HTTPS.
9. Reiniciar el servidor web y probar el formulario.

## Actualización en producción

```bash
git pull
composer install --no-dev --optimize-autoloader
```

No sobrescribir `.env` durante una actualización.

## Estructura principal

```text
assets/
  css/        Estilos
  images/     Imágenes del sitio
  js/         Interacciones
index.php     Página principal y formulario
composer.json Dependencias PHP
.env.example Variables de entorno requeridas
```

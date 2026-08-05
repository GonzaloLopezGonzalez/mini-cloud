# mini-clud

Una breve descripción de lo que hace tu aplicación (ej: Sistema de subida de ficheros y autenticación estática).

## 🚀 Requisitos Previos

Asegúrate de tener instalado en tu entorno local:
* PHP >= 8.2
* Composer
* MySQL o SQLite

## 🛠️ Instalación y Configuración

Sigue estos pasos para levantar el proyecto de forma local después de clonarlo:

**Instalar las dependencias de PHP:**
   ```bash
   composer install
   ```

**Configurar el entorno:**
   Copia el archivo de ejemplo para crear tu archivo `.env`:
   ```bash
   cp .env.example .env
   ```

**Generar la clave de la aplicación:**
   ```bash
   php artisan key:generate
   ```

**Configurar las credenciales de acceso:**
   Abre tu archivo `.env` y define el usuario administrador y su contraseña cifrada:
   ```ini
   ADMIN_USER=admin
   ADMIN_PASSWORD=\$2y\$12\$... (Genera el Hash con Tinker)
   ```

**Crear el enlace simbólico de almacenamiento:**
   Esencial para que las imágenes o ficheros subidos a `storage` sean accesibles:
   ```bash
   php artisan storage:link
   ```

**Iniciar el servidor local:**
   ```bash
   php artisan serve
   ```

## 📂 Funcionalidades Clave
* **Sanitizado de Ficheros:** Limpieza automática de nombres sustituyendo espacios por guiones antes de guardarse en el disco de Laravel.
* **Autenticación Segura:** Sistema de Login basado en credenciales protegidas dentro del archivo `.env`.
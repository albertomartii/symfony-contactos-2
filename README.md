# Symfony Contactos

Una aplicación web completa para la gestión de contactos y usuarios desarrollada con **Symfony 6.4 LTS**, **Doctrine ORM**, **Twig** y **PostgreSQL**.

![Symfony Version](https://img.shields.io/badge/Symfony-6.4_LTS-000000?style=for-the-badge&logo=symfony&logoColor=white)
![PHP Version](https://img.shields.io/badge/PHP-%3E%3D_8.1-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Doctrine](https://img.shields.io/badge/Doctrine-ORM_3.7-FF6C37?style=for-the-badge&logo=doctrine&logoColor=white)
![License](https://img.shields.io/badge/License-Proprietary-blue?style=for-the-badge)

---

## Tabla de Contenidos
- [Características](#características)
- [Tecnologías Utilizadas](#tecnologías-utilizadas)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Rutas y Endpoints](#rutas-y-endpoints)
- [Requisitos Previos](#requisitos-previos)
- [Instalación y Configuración](#instalación-y-configuración)
- [Comandos Útiles de Console](#comandos-útiles-de-console)
- [Licencia](#licencia)

---

## Características

- **Gestión de Contactos (CRUD)**: Creación, consulta detallada, edición y eliminación de contactos.
- **Relaciones entre Entidades**: Asociación de contactos con sus respectivas provincias (`ManyToOne`).
- **Búsqueda Avanzada**: Filtrado dinámico de contactos por la primera letra de su nombre.
- **Autenticación y Seguridad**: Sistema de inicio de sesión (`/login`) y cierre de sesión (`/logout`) mediante Symfony Security Bundle.
- **Registro y Verificación por Email**: Alta de nuevos usuarios con hash seguro de contraseña y confirmación de correo mediante token firmado (`SymfonyCasts VerifyEmailBundle`).
- **Interfaz Dinámica**: Plantillas modulares creadas con Twig (`base.html.twig`, partials) y estilizadas mediante CSS personalizado.

---

## Tecnologías Utilizadas

- **Backend**: PHP 8.1+ & Framework Symfony 6.4 LTS
- **ORM & Base de Datos**: Doctrine ORM 3.7, Doctrine Migrations & PostgreSQL (vía Docker)
- **Motor de Plantillas**: Twig Bundle
- **Seguridad**: Symfony Security, UserPasswordHasher, VerifyEmailBundle
- **Formularios y Validación**: Symfony Form & Validator Bundles
- **Entorno y Contenedores**: Docker & Docker Compose

---

## Estructura del Proyecto

```text
symfony-contactos/
├── bin/                      # Ejecutables de la consola de Symfony
├── config/                   # Configuración del proyecto y paquetes (security, routes, packages)
├── migrations/               # Archivos de migración de base de datos
├── public/                   # Punto de entrada público (index.php) y assets (css/estilos.css)
├── src/
│   ├── Controller/           # Controladores de la aplicación
│   │   ├── ContactoController.php     # Lógica CRUD de contactos y filtrado
│   │   ├── PageController.php         # Páginas estáticas / Inicio
│   │   ├── RegistrationController.php # Registro y verificación de email
│   │   └── SecurityController.php     # Login y Logout
│   ├── Entity/               # Entidades de Doctrine
│   │   ├── Contacto.php               # Entidad Contacto
│   │   ├── Provincia.php              # Entidad Provincia
│   │   └── User.php                   # Entidad Usuario
│   ├── Form/                 # Form de Symfony (ContactoFormType, RegistrationFormType)
│   ├── Repository/           # Consultas avanzadas a BD (ContactoRepository, etc.)
│   └── Security/             # Servicios auxiliares de seguridad (EmailVerifier)
├── templates/                # Vistas en Twig (listas, fichas, formularios, layouts)
├── compose.yaml              # Configuración de Docker Compose (PostgreSQL)
├── composer.json             # Dependencias del proyecto
└── .env                      # Variables de entorno por defecto
```

---

## Rutas y Endpoints

### Contactos

| Método | Ruta | Nombre de Ruta | Descripción |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | `inicio` | Página principal de bienvenida |
| `GET` | `/contacto/lista` | `lista_contactos` | Muestra el listado de todos los contactos |
| `GET` / `POST` | `/contacto/nuevo` | `nuevo_contacto` | Formulario para añadir un nuevo contacto |
| `GET` | `/contacto/{codigo}` | `contacto` | Muestra la ficha individual de un contacto por ID |
| `GET` | `/contacto/empieza/{letra}` | `empieza-por` | Lista contactos cuyo nombre empieza por una letra |
| `GET` / `POST` | `/contacto/modificar/{id}/{nombre}` | `modificar` | Actualiza el nombre de un contacto existente |
| `GET` / `POST` | `/contacto/borrar/{codigo}` | `borrar` | Elimina un contacto de la base de datos |

### Autenticación y Usuarios

| Método | Ruta | Nombre de Ruta | Descripción |
| :--- | :--- | :--- | :--- |
| `GET` / `POST` | `/login` | `app_login` | Formulario e inicio de sesión de usuario |
| `GET` | `/logout` | `app_logout` | Cierre de sesión de usuario |
| `GET` / `POST` | `/register` | `app_register` | Registro de nuevos usuarios |
| `GET` | `/verify/email` | `app_verify_email` | Verificación del correo electrónico registrado |

---

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado en tu sistema:
- **PHP** >= 8.1 con las extensiones requeridas (`pdo`, `pdo_pgsql`/`pdo_mysql`, `ctype`, `iconv`, `mbstring`)
- **Composer** (v2.x)
- **Docker** & **Docker Compose** (opcional pero recomendado para el servidor de base de datos)
- **Symfony CLI** (opcional, para ejecutar el servidor local de desarrollo fácilmente)

---

## Instalación y Configuración

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/tu-usuario/symfony-contactos.git
   cd symfony-contactos
   ```

2. **Instalar las dependencias con Composer:**
   ```bash
   composer install
   ```

3. **Configurar las variables de entorno:**
   Crea un archivo `.env.local` copiando `.env` o modificando la cadena de conexión a la base de datos:
   ```bash
   cp .env .env.local
   ```
   Ajusta la variable `DATABASE_URL` según tu entorno:
   ```ini
   DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
   ```

4. **Levantar la base de datos con Docker (opcional):**
   ```bash
   docker compose up -d
   ```

5. **Ejecutar las migraciones de base de datos:**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

6. **Iniciar el servidor de desarrollo:**
   Si tienes instalada la **Symfony CLI**:
   ```bash
   symfony server:start
   ```
   O utilizando el servidor embebido de PHP:
   ```bash
   php -S localhost:8000 -t public
   ```

7. **Acceder a la aplicación:**
   Abre tu navegador e ingresa a `http://localhost:8000`.

---

## Comandos Útiles de Console

- **Verificar las rutas registradas:**
  ```bash
  php bin/console debug:router
  ```
- **Crear una nueva Entidad / Modificar existente:**
  ```bash
  php bin/console make:entity
  ```
- **Generar una nueva migración:**
  ```bash
  php bin/console make:migration
  ```
- **Limpiar la caché del proyecto:**
  ```bash
  php bin/console cache:clear
  ```

---

## Licencia

Este proyecto está bajo la licencia **Proprietary**. Todos los derechos reservados.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Documentación de API

## Introducción

Este proyecto es una API desarrollada en Laravel 11 que permite gestionar usuarios, proyectos y tareas. La API proporciona endpoints para registrar usuarios, iniciar sesión, y CRUD de proyectos y tareas. Todos los endpoints que requieren autenticación utilizan un token JWT.

## Requisitos Previos

-   PHP 8.0 o superior
-   Composer
-   Laravel 11
-   Base de datos (MySQL, PostgreSQL, etc.)

## Instalación

1. Clonar el repositorio:
    ```bash
    git clone https://github.com/Esteve-Paredes/auth-task-app
    cd auth-task-app
    ```
2. Instalar las dependencias:

    ```bash
    composer install
    ```

3. Crear Base de datos:

    Crear tu base de datos con un nombre claro

4. Configurar el archivo .env:

    Ajustar las variables de entorno en el archivo .env según la configuración de su base de datos y otros parámetros.

5. Ejecutar las migraciones:

    ```bash
    php artisan migrate
    ```

6. Generar la clave de aplicación:

    ```bash
    php artisan key:generate
    ```

7. Iniciar el servidor:

    ```bash
    php artisan serve
    ```

### Proyectos

1. **GET /api/projects**
    - **Descripción:** Listar todos los proyectos del usuario autenticado.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```
2. **POST /api/projects**

    - **Descripción:** Crear un nuevo proyecto.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```
    - **Request Body:**
        ```json
        {
            "title": "string",
            "description": "string"
        }
        ```

3. **GET /api/projects/{id}**

    - **Descripción:** Obtener detalles de un proyecto específico.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```

4. **PUT /api/projects/{id}**

    - **Descripción:** Actualizar un proyecto existente.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```
    - **Request Body:**
        ```json
        {
            "title": "string",
            "description": "string"
        }
        ```

5. **DELETE /api/projects/{id}**
    - **Descripción:** Eliminar un proyecto.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```

### Tareas

1. **GET /api/projects/{projectId}/tasks**

    - **Descripción:** Listar todas las tareas de un proyecto específico.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```

2. **POST /api/projects/{projectId}/tasks**

    - **Descripción:** Crear una nueva tarea dentro de un proyecto.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```
    - **Request Body:**
        ```json
        {
            "title": "string",
            "description": "string",
            "status": "string"
        }
        ```

3. **GET /api/projects/{projectId}/tasks/{taskId}**

    - **Descripción:** Obtener detalles de una tarea específica.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```

4. **PUT /api/projects/{projectId}/tasks/{taskId}**

    - **Descripción:** Actualizar una tarea existente.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```
    - **Request Body:**
        ```json
        {
            "title": "string",
            "description": "string",
            "status": "string"
        }
        ```

5. **DELETE /api/projects/{projectId}/tasks/{taskId}**
    - **Descripción:** Eliminar una tarea.
    - **Headers:**
        ```
        Authorization: Bearer <token>
        ```

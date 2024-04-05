# Integradora Api

Este es un proyecto desarrollado con Angular y Laravel.

## Instalación

Para instalar y ejecutar este proyecto, sigue los siguientes pasos:

1. Clona el repositorio en tu máquina local.

2. Navega hasta el directorio del proyecto.

3. Instala las dependencias del proyecto con el siguiente comando:

    ```bash
    composer install
    ```

4. Instala un entorno virtual. En este ejemplo, usaremos XAMPP versión 8.1.25.

5. Descarga e instala las herramientas de pecl desde [aquí](https://pecl.php.net/package/mongodb/1.13.0).

6. Descomprime el archivo descargado de pecl. Encontrarás 7 archivos. Utiliza el que termina en .dll y .pdb.

7. Copia los archivos seleccionados a la ruta `xampp/php/ext`.

8. Agrega la siguiente línea al final del apartado de extensiones en el archivo `php.ini`:

    ```ini
    extension=php_mongodb.dll
    ```

9. Si la base de datos no está creada, créala en MySQL.

10. Inicia el servidor de desarrollo de Laravel con el siguiente comando, reemplazando `192.168.100.84` con la IP de tu máquina:

    ```bash
    php artisan serve --host=192.168.100.84
    ```

Ahora deberías poder acceder a la aplicación en tu navegador en `http://192.168.100.84:8000`.

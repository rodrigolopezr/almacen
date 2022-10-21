# Proyecto Creado con LARAVEL 9 Y VUEJS 2

INSTRUCCIONES DE INSTALACION BACKEND LARAVEL - MYSQL

#Ir a la carpeta backend
> cd backend

#Instalar librerias
>composer update

#Configurar .env
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
>DB_DATABASE=almacen
>DB_USERNAME=root
>DB_PASSWORD=
>APP_KEY=base64:d00INexymIs1lBPmJ4AbubHuCGipoRzRmxKLPoPWd+M=
    
#Ejecutar Migraciones
>php artisan migrate

#Ejecutar seed
>php artisan db:seed

#Ejecutar servicio
php artisan serve 

#ó
php -S localhost:8000 -t public/

INSTRUCCIONES DE INSTALACION FRONTEND VUEJS
#Ir a la carpeta frontend
>cd frontend

#Instalar modules
yarn install

#Configurar .env
VUE_APP_API_BASE_URL='http://localhost:8000/api'

#Ejecutar app
yarn serve

Los atributos de cada producto se mostraran al dar clic en el icono "Flecha hacía abajo" de cada renglón

taskApp1
========
taskApp
=======

A Symfony project created on June 18, 2018, 3:57 am.
# Taskapp

ir a la carpeta de crear el proyecto 

descargar symfony: php -r "file_put_contents('symfony', file_get_contents('https://symfony.com/installer'));"

crear nuevo pruyecto: ./symfony new my_project_name 3.4

ir a la carpeta creada

correr el servidor: php bin/console server:run

configurar los datos de sql

crear la base de datos: php bin/console doctrine:database:create

create Entity: php bin/console doctrine:generate:entity

Crear el crud:  php bin/console generate:doctrine:crud

actualizar base de datos: php bin/console doctrine:schema:update --force

modificar la base de datos: php bin/console doctrine:schema:update --force

create controller: php bin/console generate:controller

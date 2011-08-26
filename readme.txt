Sistema de almacenamiento de archivos

Requerimientos:

PHP 5.2 +
MySQL 5.0+
Servidor web (Apache, Lighttpd, Nginx)

Instalacion:

1. Crear una base de datos:

mysql -u root;
CREATE DATABASE filepush;
CREATE USER 'filepush'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL ON filepush.* TO 'filepush'@'localhost'

2. Copiar los archivos al servidor


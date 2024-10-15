#!/bin/bash

# Variables de configuración
DB_ROOT_USER="root"                      # Usuario root de MySQL/MariaDB
DB_ROOT_PASS="tu_contraseña_root"        # Contraseña del usuario root
DB_NAME="pantalla"                       # Nombre de la base de datos
DB_USER="PANTALLA"                       # Nombre del nuevo usuario
DB_PASS="sELECT1334!"                    # Contraseña del nuevo usuario

# Crear base de datos
echo "Creando la base de datos..."
mysql -u"$DB_ROOT_USER" -p"$DB_ROOT_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME;"

# Crear usuario y otorgar permisos
echo "Creando el usuario y otorgando permisos..."
mysql -u"$DB_ROOT_USER" -p"$DB_ROOT_PASS" -e "CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';"
mysql -u"$DB_ROOT_USER" -p"$DB_ROOT_PASS" -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';"
mysql -u"$DB_ROOT_USER" -p"$DB_ROOT_PASS" -e "FLUSH PRIVILEGES;"

# Crear tablas
echo "Creando tablas en la base de datos '$DB_NAME'..."

# Tabla para almacenar los comandos
mysql -u"$DB_ROOT_USER" -p"$DB_ROOT_PASS" -D"$DB_NAME" -e "
CREATE TABLE IF NOT EXISTS comandos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    boxId VARCHAR(10) NOT NULL,
    action VARCHAR(50) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);"

# Tabla para almacenar las imágenes
mysql -u"$DB_ROOT_USER" -p"$DB_ROOT_PASS" -D"$DB_NAME" -e "
CREATE TABLE IF NOT EXISTS imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ruta VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);"

echo "La base de datos '$DB_NAME' y las tablas necesarias han sido creadas con éxito."

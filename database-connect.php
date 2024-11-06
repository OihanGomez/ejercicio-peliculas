<?php
$servername = "db";
$username = "root";
$password = "root";
$dbname = "mydatabase";

try {
    // Conexión a MySQL
    $conn = new mysqli($servername, $username, $password);

    // Crear la base de datos si no existe
    $createDB = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($createDB) === FALSE) {
        echo "Error al crear la base de datos.<br>";
    }

    // Conectar a la base de datos recién creada
    $conn->select_db($dbname);

    // Crear la tabla 'users_peliculas' si no existe
    $createUsersTable = "CREATE TABLE IF NOT EXISTS users_peliculas (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )";
    if ($conn->query($createUsersTable) === FALSE) {
        echo "Error al crear la tabla users_peliculas.<br>";
    }

    // Crear la tabla 'peliculas' si no existe
    $createPeliculasTable = "CREATE TABLE IF NOT EXISTS peliculas (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user VARCHAR(255) NOT NULL,
        nombre_pelicula VARCHAR(255),
        isan CHAR(8) NOT NULL UNIQUE,
        year INT,
        puntuacion TINYINT,
        FOREIGN KEY (user) REFERENCES users_peliculas(name)
    )";
    if ($conn->query($createPeliculasTable) === FALSE) {
        echo "Error al crear la tabla peliculas.<br>";
    }

} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>

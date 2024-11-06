<?php
require_once 'database-connect.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];

    // Consulta para verificar si el usuario ya existe
    $sql = "SELECT * FROM users_peliculas WHERE name = '$nombre'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) { // Si el usuario no existe
        // Inserta un nuevo usuario en la base de datos
        $sql = "INSERT INTO users_peliculas (name, password) VALUES ('$nombre', '$contraseña')";
        if ($conn->query($sql) === TRUE) {
            echo "Usuario registrado exitosamente."; // Mensaje de éxito
        } else {
            echo "Error al registrar el usuario: " . $conn->error; // Mensaje de error
        }
    } else {
        echo "El usuario ya existe."; // Mensaje si el usuario ya está registrado
    }
}
?>

<!-- Formulario para registro -->
<form method="POST" action="registro.php"> 
    Nombre: <input type="text" name="nombre" required><br>
    Contraseña: <input type="password" name="contraseña" required><br>
    <button type="submit">Registrarse</button>
</form>

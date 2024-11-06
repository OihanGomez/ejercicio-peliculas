<?php
session_start();
require_once 'database-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre']; 
    $contraseña = $_POST['contraseña']; 

    // Consulta para verificar las credenciales del usuario
    $sql = "SELECT * FROM users_peliculas WHERE name = '$nombre' AND password = '$contraseña'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) { // Si se encuentra un usuario con las credenciales correctas
        $_SESSION['usuario'] = $nombre; // Almacena el nombre de usuario en la sesión
        header("Location: peliculas.php"); // Redirige a la página de películas
        exit();
    } else {
        echo "Nombre o contraseña incorrectos."; // Mensaje de error si las credenciales son incorrectas
    }
}
?>

<!-- Formulario para iniciar sesión -->
<form method="POST" action="login.php"> 
    Nombre: <input type="text" name="nombre" required><br>
    Contraseña: <input type="password" name="contraseña" required><br>
    <button type="submit">Iniciar sesión</button>
</form>
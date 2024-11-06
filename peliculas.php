<?php
session_start(); // Inicia la sesión

include 'database-connect.php'; // Conexión a la base de datos

// Verifica si el usuario ha iniciado sesión antes de continuar
if (isset($_SESSION['usuario'])) {
    $nombre_usuario = $_SESSION['usuario'];
} else {
    die("Debe iniciar sesión para ver esta página.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_pelicula = $_POST['nombre_pelicula'];
    $isan = $_POST['isan'];
    $año = $_POST['año'];
    $puntuacion = $_POST['puntuacion'];

    if (strlen($isan) == 8) {
        $sql = "SELECT * FROM peliculas WHERE isan = '$isan'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            if (empty($nombre_pelicula)) { // Eliminar película si no se proporciona nombre
                $sql = "DELETE FROM peliculas WHERE ISAN = '$isan'";
                echo $conn->query($sql) === TRUE ? "Película eliminada correctamente." : "Error al eliminar la película: " . $conn->error;
            } else { // Actualizar película si se proporciona un nuevo nombre
                $sql = "UPDATE peliculas SET nombre_pelicula = '$nombre_pelicula', year = $año, puntuacion = $puntuacion WHERE isan = '$isan'";
                echo $conn->query($sql) === TRUE ? "Película actualizada correctamente." : "Error al actualizar la película: " . $conn->error;
            }
        } else {
            if (!empty($nombre_pelicula) && !empty($año) && !empty($puntuacion)) { // Añadir nueva película si no existe
                $sql = "INSERT INTO peliculas (user, nombre_pelicula, isan, year, puntuacion) VALUES ('$nombre_usuario', '$nombre_pelicula', '$isan', $año, $puntuacion)";
                echo $conn->query($sql) === TRUE ? "Película añadida correctamente." : "Error al añadir la película: " . $conn->error;
            } else {
                echo "Por favor, rellena todos los campos.";
            }
        }
    } else {
        echo "El ISAN debe tener 8 dígitos.";
    }
}
?>

<h2>Añadir/Actualizar/Eliminar película</h2>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Nombre de la película: <input type="text" name="nombre_pelicula"><br>
    ISAN (8 dígitos): <input type="text" name="isan" required><br>
    Año: <input type="number" name="año"><br>
    Puntuación: 
    <select name="puntuacion">
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select><br>
    <button type="submit">Enviar</button>
</form>

<?php
// Consulta para obtener las películas del usuario
$sql = "SELECT * FROM peliculas WHERE user = '$nombre_usuario'";
$result = $conn->query($sql);
?>

<table>
    <tr>
        <th>User</th>
        <th>Isan</th>
        <th>Nombre de película</th>
        <th>Puntuación</th>
        <th>Año</th>
    </tr>
    <?php
    // Verificar si hay resultados y mostrarlos
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>".$row['user']."</td>
            <td>".$row['isan']."</td>
            <td>".$row['nombre_pelicula']."</td>
            <td>".$row['puntuacion']."</td>
            <td>".$row['year']."</td>
            </tr>";
        }
    }
    ?>
</table>
<?php
// Conectar a la base de datos
include 'conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada aquí

// Verificar si se ha pasado un usuario_id en la URL
$usuario_id = isset($_GET['usuario_id']) ? (int)$_GET['usuario_id'] : 0;

// Si se ha pasado un usuario_id, obtenemos sus publicaciones
if ($usuario_id > 0) {
    // Obtener las publicaciones del usuario
    $sql = "SELECT p.contenido, u.nombre 
            FROM posts p 
            JOIN usuarios u ON p.usuario_id = u.id 
            WHERE p.usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Obtener el nombre del usuario
    $nombre_usuario = "";
    if ($result->num_rows > 0) {
        $row_usuario = $result->fetch_assoc();
        $nombre_usuario = htmlspecialchars($row_usuario['nombre']);
        // Reseteamos el resultado para mostrar las publicaciones
        $result->data_seek(0);
    }
} else {
    // Obtener la lista de usuarios si no se ha pasado un usuario_id
    $sql = "SELECT id, nombre FROM usuarios";
    $result = $conexion->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $usuario_id > 0 ? "Publicaciones de $nombre_usuario" : "Lista de Usuarios"; ?></title>
</head>
<body>
    <h1><?php echo $usuario_id > 0 ? "Publicaciones de $nombre_usuario" : "Lista de Usuarios"; ?></h1>

    <?php if ($usuario_id > 0): ?>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div>
                    <strong>Imagen del post:</strong><br>
                    <p><?php echo htmlspecialchars($row['contenido']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay publicaciones disponibles para este usuario.</p>
        <?php endif; ?>
        <a href="usuarios.php">Volver a la lista de usuarios</a>
    <?php else: ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <a href="usuarios.php?usuario_id=<?php echo $row['id']; ?>">
                        Usuario <?php echo $row['id']; ?> - <?php echo htmlspecialchars($row['nombre']); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

</body>
</html>

<?php
// Cerrar conexión
if (isset($stmt)) {
    $stmt->close();
}
$conexion->close();
?>

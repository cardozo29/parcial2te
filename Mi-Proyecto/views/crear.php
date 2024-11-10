<?php
// crear.php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    // Preparar la consulta SQL para evitar inyección SQL
    $stmt = $conn->prepare("INSERT INTO posts (titulo, contenido) VALUES (?, ?)");
    $stmt->bind_param("ss", $titulo, $contenido);

    if ($stmt->execute()) {
        $mensaje = "Post creado exitosamente.";
    } else {
        $mensaje = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Post</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .form-container { width: 50%; margin: auto; }
        label { display: block; margin-top: 10px; }
        input[type="text"], textarea { width: 100%; padding: 8px; }
        input[type="submit"] { margin-top: 10px; padding: 10px 20px; }
        .mensaje { margin-top: 20px; color: green; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Crear Nuevo Post</h2>
        <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
        <form method="POST" action="crear.php">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido" rows="5" required></textarea>

            <input type="submit" value="Crear">
        </form>
        <br>
        <a href="mostrar.php">Ver Posts Creados</a>
    </div>
</body>
</html>

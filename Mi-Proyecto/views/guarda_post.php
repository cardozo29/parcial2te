<?php
session_start();
require_once '../inc/conexion.php'; // Incluye la conexión a la base de datos

// Verifica que el usuario esté logueado y tenga un ID en la sesión
$idUsuario = isset($_SESSION['usuarios_id']) ? $_SESSION['usuarios_id'] : 0;

if ($idUsuario == 0) {
    echo "Error: Usuario no autenticado.";
    exit();
}

// Verifica que se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $imagen = null;

    // Si se cargó una imagen, guárdala en el servidor y obtén la ruta
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaDestino = 'uploads/' . $nombreImagen;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $rutaDestino;
        } else {
            echo "Error al cargar la imagen.";
            exit();
        }
    }

    // Inserta el post en la base de datos
    try {
        $stmt = $conexion->prepare("INSERT INTO post (usuario_id, titulo, descripcion, imagen) VALUES (:usuario_id, :titulo, :descripcion, :imagen)");
        $stmt->bindParam(':usuario_id', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':imagen', $imagen);

        if ($stmt->execute()) {
            echo "Post creado exitosamente.";
        } else {
            echo "Error al crear el post.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Método de solicitud no válido.";
}
?>

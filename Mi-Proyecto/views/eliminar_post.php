<?php
session_start();
require_once '../inc/conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del post a eliminar
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Obtener la imagen del post antes de eliminar
    try {
        $stmt = $conexion->prepare("SELECT imagen FROM posts WHERE id = :post_id LIMIT 1");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            // Nombre de la imagen a eliminar
            $imagen = $post['imagen'];
            $file_path = "../view/uploads/" . $imagen;

            // Eliminar la imagen del servidor
            if (file_exists($file_path)) {
                unlink($file_path);  // Elimina la imagen
            }

            // Eliminar el post de la base de datos
            $stmt = $conexion->prepare("DELETE FROM posts WHERE id = :post_id");
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirigir a la página de posts
            header("Location: post.php");
            exit();
        } else {
            echo "Post no encontrado.";
        }
    } catch (PDOException $e) {
        echo "Error al eliminar el post: " . $e->getMessage();
    }
} else {
    // Si no se pasa el parámetro `id`, redirigir a la lista de posts
    header("Location: posts.php");
    exit();
}
?>

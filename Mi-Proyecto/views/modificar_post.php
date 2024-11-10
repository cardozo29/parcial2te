<?php
session_start();
require_once '../inc/conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del post a modificar
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
} else {
    header("Location: posts.php");
    exit();
}

// Obtener los detalles del post
$post = null;
try {
    $stmt = $conexion->prepare("SELECT * FROM posts WHERE id = :post_id LIMIT 1");
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al recuperar el post: " . $e->getMessage();
    exit();
}

// Verificar si el post existe
if (!$post) {
    echo "Post no encontrado.";
    exit();
}

// Procesar la actualización del post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];

    // Verificar si se subió una imagen nueva
    if ($imagen) {
        // Verificar si el archivo se subió sin errores
        if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Directorio de destino donde se guardará la imagen
            $target_dir = "C:/xampp/htdocs/Mi-Proyecto/uploads/";  // Ajusta la ruta
            $target_file = $target_dir . basename($imagen);

            // Mover el archivo subido al directorio de destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                // Actualizar el post con la nueva imagen
                $stmt = $conexion->prepare("UPDATE posts SET titulo = :titulo, descripcion = :descripcion, imagen = :imagen WHERE id = :post_id");
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':imagen', $imagen);
                $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            } else {
                echo "Error al mover el archivo al directorio de destino.";
                exit();
            }
        } else {
            echo "Error al subir la imagen. Código de error: " . $_FILES['imagen']['error'];
            exit();
        }
    } else {
        // Si no hay nueva imagen, actualizar solo el título y la descripción
        $stmt = $conexion->prepare("UPDATE posts SET titulo = :titulo, descripcion = :descripcion WHERE id = :post_id");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    }

    try {
        // Ejecutar la actualización
        $stmt->execute();
        // Redirigir a posts.php después de actualizar el post
        header("Location: post.php");
        exit(); // Asegurarse de que el script se detenga aquí
    } catch (PDOException $e) {
        echo "Error al actualizar el post: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Post</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        /* Estilos de la página */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2d9cdb;
            font-size: 36px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            background-color: #f9f9f9;
            margin-bottom: 10px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, textarea:focus, input[type="file"]:focus {
            border-color: #2d9cdb;
            outline: none;
        }

        textarea {
            resize: vertical;
            height: 150px;
        }

        .form-group img {
            max-width: 200px;
            margin: 10px 0;
            border-radius: 8px;
        }

        button {
            background-color: #2d9cdb;
            color: white;
            border: none;
            padding: 14px 30px;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2378b7;
        }

        .back-btn {
            text-decoration: none;
            color: #2d9cdb;
            font-size: 18px;
            margin-bottom: 20px;
            display: inline-block;
            border: 2px solid #2d9cdb;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .back-btn:hover {
            background-color: #2d9cdb;
            color: white;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="post.php" class="back-btn">Regresar</a>
    <h1>Modificar Post</h1>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($post['titulo']); ?>" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($post['descripcion']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="imagen">Imagen actual</label>
            <img src="../uploads/<?php echo htmlspecialchars($post['imagen']); ?>" alt="Imagen del Post">
        </div>

        <div class="form-group">
            <label for="imagen">Imagen (opcional)</label>
            <input type="file" id="imagen" name="imagen">
        </div>

        <button type="submit">Guardar Cambios</button>
    </form>
</div>

<div class="footer">
    <p>&copy; 2024 Biblioteca de Apuntes Inteligente. Todos los derechos reservados.</p>
</div>

</body>
</html>

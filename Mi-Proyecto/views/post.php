<?php
session_start();
require_once '../inc/conexion.php';

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener lista de usuarios
$usuarios = [];
try {
    $stmt = $conexion->prepare("SELECT id, username FROM users");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al recuperar los usuarios: " . $e->getMessage();
}

// Filtrar posts por usuario seleccionado
$usuario_id = isset($_GET['usuario_id']) ? (int)$_GET['usuario_id'] : 0;
try {
    if ($usuario_id > 0) {
        $stmt = $conexion->prepare("SELECT * FROM posts WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->bindParam(':user_id', $usuario_id, PDO::PARAM_INT);
    } else {
        $stmt = $conexion->prepare("SELECT * FROM posts ORDER BY id DESC");
    }
    $stmt->execute();
    $post = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al recuperar las publicaciones: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts por Usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .user-links {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .user-links a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
            font-size: 16px;
        }

        .posts-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .post {
            background-color: #f9f9f9;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            position: relative;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .post img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .post h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: white;
            background-color: red;
            padding: 5px 0;
        }

        .post p {
            color: #333;
            font-size: 14px;
            margin-bottom: 10px;
            background-color: red;
            color: white;
            padding: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer; /* Mostrar que es interactivo */
            transition: all 0.3s ease;
        }

        .post p.expanded {
            white-space: normal;
            height: auto; /* Permitir que se expanda */
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        .buttons a {
            text-decoration: none;
            padding: 5px 15px;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .delete {
            background-color: #dc3545;
        }

        .delete:hover {
            background-color: #c82333;
        }

        .edit {
            background-color: #28a745;
        }

        .edit:hover {
            background-color: #218838;
        }

        .back-button {
            text-align: right;
            margin-bottom: 20px;
        }

        .back-button a {
            text-decoration: none;
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
    <script>
        // Función para alternar la expansión de la descripción
        document.addEventListener('DOMContentLoaded', function() {
            const descriptions = document.querySelectorAll('.post p');
            descriptions.forEach(description => {
                description.addEventListener('click', function() {
                    if (description.classList.contains('expanded')) {
                        description.classList.remove('expanded');
                        description.style.whiteSpace = 'nowrap'; // Volver a una sola línea
                        description.style.height = 'auto'; // Restablecer altura original
                    } else {
                        // Ocultar otras descripciones expandidas
                        descriptions.forEach(desc => {
                            desc.classList.remove('expanded');
                            desc.style.whiteSpace = 'nowrap'; // Volver a una sola línea
                            desc.style.height = 'auto'; // Restablecer altura original
                        });
                        description.classList.add('expanded');
                        description.style.whiteSpace = 'normal'; // Permitir líneas múltiples
                        description.style.height = 'auto'; // Expandir altura
                    }
                });
            });

            // Evento para contraer la descripción al hacer clic fuera de ella
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.post p')) {
                    descriptions.forEach(desc => {
                        desc.classList.remove('expanded');
                        desc.style.whiteSpace = 'nowrap'; // Volver a una sola línea
                        desc.style.height = 'auto'; // Restablecer altura original
                    });
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <!-- Botón de regreso -->
        <div class="back-button">
            <a href="javascript:history.back()">Regresar</a>
        </div>
        <!-- Enlaces de usuarios -->
        <div class="user-links">
            <?php foreach ($usuarios as $usuario): ?>
                <a href="post.php?usuario_id=<?php echo $usuario['id']; ?>">
                    <?php echo htmlspecialchars($usuario['username']); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Contenedor de los posts -->
        <div class="posts-container">
            <?php foreach ($post as $post): ?>
                <div class="post">
                    <!-- Mostrar imagen si existe -->
                    <?php if (!empty($post['imagen'])): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($post['imagen']); ?>" alt="Imagen del post">
                    <?php else: ?>
                        <img src="../uploads/default.png" alt="Imagen por defecto">
                    <?php endif; ?>

                    <h2><?php echo htmlspecialchars($post['titulo']); ?></h2>
                    <p><?php echo htmlspecialchars($post['descripcion']); ?></p>

                    <div class="buttons">
                        <a href="eliminar_post.php?id=<?php echo $post['id']; ?>" class="delete">Eliminar</a>
                        <a href="modificar_post.php?id=<?php echo $post['id']; ?>" class="edit">Modificar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

<?php
session_start();
require_once '../inc/conexion.php'; // Incluye la conexión a la base de datos
require_once '../inc/funciones.php'; // Incluye funciones adicionales

if (!verificar_rol('admin')) {
    echo "Acceso denegado.";
    exit;
}

// Obtén el ID del usuario desde la sesión
$idUsuario = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Usar el ID del usuario si está en sesión

// Variables de error
$errorTitulo = $errorDescripcion = $errorImagen = "";
$titulo = $descripcion = "";

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['titulo'])) {
        $errorTitulo = "Ingrese un título.";
    } else {
        $titulo = htmlspecialchars($_POST['titulo']);
    }

    if (empty($_POST['descripcion'])) {
        $errorDescripcion = "Ingrese una descripción.";
    } else {
        $descripcion = htmlspecialchars($_POST['descripcion']);
    }

    if ($_FILES['imagen']['error'] != 0) {
        $errorImagen = "Error en la subida de la imagen.";
    }

    // Procesa el formulario si no hay errores
    if (empty($errorTitulo) && empty($errorDescripcion) && empty($errorImagen)) {
        // Definir la ruta donde se guardará la imagen
        $directorio = "uploads/"; // Carpeta donde se guardarán las imágenes
        $archivoImagen = $directorio . basename($_FILES["imagen"]["name"]); // Nombre del archivo de imagen

        // Mueve el archivo subido a la carpeta 'uploads'
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $archivoImagen)) {
            try {
                // Inserta los datos en la base de datos
                $stmt = $conexion->prepare("INSERT INTO posts (titulo, descripcion, imagen) VALUES (:titulo, :descripcion, :imagen)");
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':imagen', $archivoImagen);

                $stmt->execute();

                echo "Post guardado exitosamente.";
            } catch (PDOException $e) {
                echo "Error al guardar el post: " . $e->getMessage();
            }
        } else {
            $errorImagen = "Hubo un error al subir la imagen.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header a {
            margin-right: 20px;
            text-decoration: none;
            color: black;
            font-size: 18px;
        }

        .caja {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .caja h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        .caja p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
            text-align: center;
        }

        .formulario {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center; /* Centra el texto dentro del formulario */
        }

        .formulario label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .formulario input[type="text"],
        .formulario input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Eliminar el cuadro (borde) solo para el campo de imagen */
        .formulario input[type="file"] {
            border: none;
        }

        .formulario button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .formulario button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <a href="dashboard.php">Volver al Dashboard</a>
        <a href="post.php">Post creados</a>
    </header>

    <div class="caja">
        <div class="formulario">
            <h2>Área de Administración</h2>
            <p style="
            padding-left: 47px;
            padding-right: 31px;
            ">Formulario para la creación de un post asociado al ID: <?php echo $idUsuario; ?>, con conexión activa.</p>
            
            <form action="admin.php" method="post" enctype="multipart/form-data">
            <label for="titulo" style="
            width: 49px;
            ">Título:</label>               
             <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
                <?php if ($errorTitulo): ?>
                 <p class="error" style="
                width: 121px;
                ">Ingrese un título.</p>
                <?php endif; ?>

                <label for="descripcion" style="
                 width: 97px;
                ">Descripción:</label>               
                 <input type="text" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>">
                <?php if ($errorDescripcion): ?>
                    <p class="error" style="
                width: 176px;
                ">Ingrese una descripción.</p>
                <?php endif; ?>

                <label for="imagen" style="
                width: 62px;
                ">Imagen:</label>
                <input type="file" id="imagen" name="imagen">
                <?php if ($errorImagen): ?>
                    <p class="error" style="
                width: 227px;
                ">Error en la subida de la imagen.</p>
                <?php endif; ?>
                
                <button type="submit" style="
                width: 321px;
                ">Crear</button>
            </form>
        </div>
    </div>
</body>
</html>

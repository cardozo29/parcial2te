<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Verificar si el usuario no tiene imagen
if (empty($_SESSION['user_imagen']) || !isset($_SESSION['user_imagen'])) {
    // Ruta de la imagen predeterminada para usuarios sin foto
    $ruta_relativa = 'img/gatito.jpg';  // Asegúrate de que esta sea la ruta correcta
    $mostrar_texto_sin_foto = true;
} else {
    // Si el usuario tiene imagen, usarla
    $ruta_absoluta = $_SESSION['user_imagen'];
    $ruta_relativa = str_replace('C:\xampp\htdocs\curso_php\mi-proyecto\views/', '', $ruta_absoluta);
    $mostrar_texto_sin_foto = false;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Estilos generales */
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Contenedor de los enlaces superiores */
        .top-links {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .top-links a {
            margin-left: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .top-links a:hover {
            text-decoration: underline;
        }

        /* Contenedor de perfil centrado */
        .perfil-contenedor {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 300px;
        }

        /* Imagen de perfil circular */
        .perfil-imagen {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc;
            margin-top: 10px; /* Añadir espacio superior */
        }

        /* Estilos de los textos */
        h2, p {
            margin: 5px;
            color: #333;
        }

        /* Texto "Perfil sin foto" con el mismo estilo del rol */
        .texto-sin-foto {
            margin: 5px; /* Mismo margen que el texto del rol */
            color: #333; /* Color negro igual al del rol */
            font-style: normal; /* Quitar el estilo en cursiva */
        }
    </style>
</head>
<body>
    <!-- Enlaces en la parte superior derecha -->
    <div class="top-links">
        <a href="admin.php">Administración</a>
        <a href="../logout.php">Cerrar Sesión</a>
    </div>

    <!-- Contenedor de perfil centrado -->
    <div class="perfil-contenedor">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <p>Tu rol es: <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>

        <!-- Mostrar texto "Perfil sin foto" si no tiene foto de perfil -->
        <?php if ($mostrar_texto_sin_foto): ?>
            <p class="texto-sin-foto">Perfil sin foto</p>
        <?php endif; ?>

        <!-- Mostrar imagen de perfil o imagen predeterminada -->
        <img src="<?php echo htmlspecialchars($ruta_relativa); ?>" alt="Imagen de perfil" class="perfil-imagen">
    </div>
</body>
</html>

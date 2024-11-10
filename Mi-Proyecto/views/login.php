<?php
session_start();
require_once '../inc/conexion.php';
require_once '../inc/funciones.php';

$errores = [
    'error' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = limpiar_dato($_POST['email']);
    $password = $_POST['password'];

    // Consultamos si el email existe
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nombre'];
        $_SESSION['user_role'] = $usuario['rol'];
        $_SESSION['user_email'] = $usuario['email'];
        // Reto imagen
        $_SESSION['user_imagen'] = $usuario['imagen'];
        
        header("Location: dashboard.php");
        exit;
    } else {
        // echo "Email o contraseña incorrectos.";
        $errores['error'] = 'Email o contraseña incorrectos.';

    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
      
        body{
            margin: 0; /* Elimina márgenes por defecto */
        

        }
        .caja{
            display: flex; /* Activa el modo de grid */
            place-items: center; /* Centra el contenido horizontal y verticalmente */
            min-height: 100vh; /* Asegura que el body tenga al menos la altura completa de la pantalla */
            background-image: url("img/na.gif");
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            flex-direction: column;
            justify-content: space-around;
            height: 100vh;
            align-items: center;
        }
        

        header{
            display: flex; /* Activa el modo flexbox */
            justify-content: flex-end; /* Alinea horizontalmente el contenido a la derecha */
            align-items: center; /* Centra verticalmente el contenido dentro del header */
            height: 50px;
          
        }

        a{
            padding-right: 20px;
            text-decoration: none; /* Elimina el subrayado del enlace */
            color: black;
            font-size: 27px;
        }
        
        form{
            width: 100%;
            border: 2px solid #3498db; /* Color y grosor del borde */
            border-radius: 0 40px 0 10px; /* Bordes redondeados */
            padding: 10px; /* Espacio interno del post */
            margin: 2px; /* Margen externo */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra para darle profundidad */
           
        }

        h2{
            text-align: center;
        }

        input{
            width: -webkit-fill-available;
        }

        .error {
            text-align: center;
            color: red;
            font-weight: bold;
            font-size: 0.9em;
        }
        img {
            display: grid;
            padding-top: -30px;
            place-items: center;
            width: 35vh; /* Ajusta el tamaño según sea necesario */
            height: 32vh; /* Mantiene la proporción de la imagen */
            border-radius: 50%; /* Hace que la imagen sea redonda */
            object-fit: cover; /* Corta la imagen para mantener la proporción */
            margin-bottom: -60px; /* Añade espacio entre la imagen y el formulario */
            border: 5px solid #33baff; /* Borde blanco alrededor de la imagen */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Sombra para darle profundidad */
        }
       
        
    </style>
</head>
<body>

    <header>
        <a href="../index.php">Index</a>
        <a href="Registro.php">Registrar</a>
    </header>
   
    <div class="caja">
    <img src="img/pingui.gif" alt="Imagen de perfil">
        <form method="post">
        
            <h2>Inicio de Sesión</h2>
    
            <?php if (!empty($errores['error'])): ?>
                <p class="error"><?php echo $errores['error']; ?></p>
            <?php endif; ?>
    
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" >
    
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" >
    
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
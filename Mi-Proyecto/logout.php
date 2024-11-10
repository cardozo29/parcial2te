<?php
// funciones.php

function limpiar_dato($dato) {
    return htmlspecialchars(trim($dato));
}

function verificar_rol($rol) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $rol;
}

function validar_imagen($imagen) {
    if (!isset($imagen) || $imagen['error'] !== UPLOAD_ERR_OK) {
        $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION)); 
        $extensiones_permitidas = ['jpg', 'jpeg', 'png'];
        
        // Verifica si la extensión es permitida
        if (!in_array($extension, $extensiones_permitidas)) {      
            return "Formato no permitido. Solo se permiten imágenes jpg, jpeg, png o gif.";
        }
    }
    
    $tipo_mime = mime_content_type($imagen['tmp_name']);
    $mimes_permitidos = ['image/jpeg', 'image/png', 'image/gif']; 

    if (!in_array($tipo_mime, $mimes_permitidos)) {    
        return "El archivo no es una imagen válida.";
    }

    return true;
}

// Iniciar sesión, limpiar y destruir sesión, y redirigir al usuario
session_start();

// Verifica el estado de la sesión antes de destruirla
var_dump($_SESSION); // Muestra el contenido de la sesión (puedes eliminarlo después de depurar)

session_unset(); 
session_destroy(); 

// Asegúrate de que la ruta sea correcta
header("Location: views/login.php"); // Ajusta la ruta si es necesario
exit;
?>

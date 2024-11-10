<?php
try {
    $host = '127.0.0.1';
    $dbname = 'miproyecto';
    $user = 'root';
    $passwordDB = '';
    $port = '3306';

    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $passwordDB);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

$host = '127.0.0.1'; // Servidor de base de datos
$dbname = 'miproyecto'; // Nombre de la base de datos
$user = 'root'; // Usuario de MySQL (por defecto en XAMPP)
$password = ''; // Contraseña (por defecto en XAMPP es vacía)

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}


?>

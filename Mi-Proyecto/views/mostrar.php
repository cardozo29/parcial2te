<?php
// mostrar.php
include 'conexion.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Posts Creados</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .post { border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; }
        .post h3 { margin: 0; }
        .fecha { color: #777; font-size: 0.9em; }
        .container { width: 60%; margin: auto; }
        a { text-decoration: none; color: blue; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Posts</h2>
        <a href="crear.php">Crear Nuevo Post</a>
        <hr>

        <?php
        $sql = "SELECT id, titulo, contenido, fecha_creado FROM posts ORDER BY fecha_creado DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar cada post
            while($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h3>" . htmlspecialchars($row["titulo"]) . "</h3>";
                echo "<p>" . nl2br(htmlspecialchars($row["contenido"])) . "</p>";
                echo "<p class='fecha'>Creado el: " . $row["fecha_creado"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay posts creados.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

<?php
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<style>
    
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family:'Times New Roman', Times, serif;
}
.nav-links {
    font-size: 1.5rem; /* Aumenta el tamaño de la letra */
    font-weight: bold; /* Negrita */
    display: inline-block; /* Activa el modo flexbox */
    margin: 5px;
    color: #fff; /* Cambia el color del texto si es necesario */
    text-decoration: none; /* Sin subrayado */
    font-family: 'Times New Roman', Times, serif;
}
.link{
   text-align: right; 
}
/* Body and Base Styles */
body {
    background-color: #000;
    color: #fff;
}

/* Hero Section */
.hero-section {
    background: url("imagenes/paisaje.gif") no-repeat center center/cover;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

nav ul {
    list-style: none;
    display: flex;
    gap: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

.hero-content h1 {
    font-size: 4rem;
    margin-bottom: 10px;
}

.hero-content p {
    font-size: 1.2rem;
    margin-bottom: 20px;
}

.play-btn {
    background: none;
    border: 2px solid #fff;
    color: #fff;
    font-size: 1.5rem;
    padding: 10px 20px;
    cursor: pointer;
}
video {
    width: 100%;
    height: auto;
    display: none; /* Initially hidden */
}

/* Explore Section */
.explore-section {
    padding: 60px 20px;
    text-align: center;
}

.explore-section h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.explore-section p {
    font-size: 1rem;
    max-width: 700px;
    margin: 0 auto 40px;
}

.explore-cards {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.card {
    width: 200px;
    background: #333;
    border-radius: 8px;
    overflow: hidden;
    text-align: center;
}

.card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.card-info {
    padding: 15px;
}

.card-info h3 {
    font-size: 1.2rem;
}

.see-more {
    display: inline-block;
    margin-top: 20px;
    color: #00f;
    text-decoration: underline;
}

/* Journal Section */
.journal-section {
    padding: 60px 20px;
    text-align: center;
}

.journal-section h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.journal-section p {
    font-size: 1rem;
    max-width: 700px;
    margin: 0 auto 40px;
}

.journal-entries {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.entry {
    width: 300px;
    background: #333;
    border-radius: 8px;
    overflow: hidden;
}

.entry img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.entry-info {
    padding: 15px;
}

.entry-info h3 {
    font-size: 1.2rem;
}

.all-posts {
    display: inline-block;
    margin-top: 20px;
    color: #00f;
    text-decoration: underline;
}

/* Footer Section */
footer {
    background: #111;
    padding: 20px;
    text-align: center;
}

footer nav ul {
    list-style: none;
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 10px;
}

footer nav ul li a {
    color: #fff;
    text-decoration: none;
}

    </style>
<div class="link">
<a class="nav-links" href="./views/login.php">Login</a>
<a class="nav-links" href="./views/Registro.php">Registrar</a>
</div>
    <header class="hero-section">
        
        <div class="hero-content">
            <h1>La Naturaleza</h1>
            <p>"La tierra tiene música para aquellos que escuchan."</p>
        </div>
    </header>
  
    <section class="explore-section">
        <h2>Explorar la naturaleza</h2>
        <p> La naturaleza nos ofrece una oportunidad para desconectarnos de la 
            tecnología y el ritmo acelerado de la vida moderna.Lo que no solo nos enriquece a nivel personal, 
            sino que también nos recuerda la importancia de cuidar y proteger nuestro entorno. </p>
        
        <div class="explore-cards">
            <div class="card">
                <img src="imagenes/antartida.jfif" alt="Norway">
                <div class="card-info">
                    
                    <p>"El frío puede helar el aire, pero nunca puede apagar la belleza."</p>
                </div>
            </div>
            <div class="card">
                <img src="imagenes/otoño.jfif" alt="Antelope Canyon">
                <div class="card-info">
                    <p>"El viento lleva consigo el aroma del cambio, y el otoño nos abraza con su melancolía."</p>
                </div>
            </div>
            <div class="card">
                <img src="imagenes/aurora.jfif" alt="Grossglockner">
                <div class="card-info">
                    <p>"Cuando el cielo se pinta de verde y violeta, la magia del universo se revela."</p>
                </div>
            </div>
        </div>
       
    </section>

    <!-- Journal Section -->
    <section class="journal-section">
        <h2>Ecos de la Tierra</h2>
        <p>En el eco de un río que murmura,<br>
en la brisa que acaricia el suelo,<br>
la naturaleza guarda su locura,<br>
un universo vivo,<br> puro y sincero.<br><br>

Cada criatura, cada planta,<br>
es un hilo en el tejido del ser,<br>
cuidemos su danza,<br> su esencia encantada,<br>
pues en su abrazo,<br> aprendemos a ver.</p>
        
        <div class="journal-entries">
            <div class="entry">
                <img src="imagenes/mar.jfif" alt="Yosemite">
                <div class="entry-info">
                    <p>"Bajo el manto de colores cálidos, el mar se convierte en un espejo del alma."</p>
                </div>
            </div>
            <div class="entry">
                <img src="imagenes/primavera.jfif" alt="Golden Gate Bridge">
                <div class="entry-info">
                    <p>"En cada girasol, un rayo de sol; en cada atardecer, un poema de luz."</p>
                </div>
            </div>
        </div>
       
    </section>

    <!-- Footer Section -->
    <footer>
        <p>© 2024 La Naturaleza. </p>
        
    </footer>

</body>
</html>
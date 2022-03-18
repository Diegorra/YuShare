<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
  <title>YouShare</title>
  <link rel="stylesheet" type="text/css" href="style/style.css">
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="images/minilogo.png">
</head>

<body>
  <!-- CABECERA DE LA PÁGINA CON IMAGEN Y MENÚ -->
  <?php
    require("includes/comun/cabecera.php");
    require("includes/comun/search.php")
  ?>

  <!-- AQUÍ VA EL CUERPO DE LA PÁGINA -->
  <div class="cuerpo_peliculas">

    <h1><br>Películas de las que más se hablan</h1>

  	<div class="texto_inicio">
  		  <img src="images/peliculas/star_wars.jpg" id="image_inicio" title="Star Wars">
  		  <img src="images/peliculas/avengers.jpg" id="image_inicio" title="Avengers">
  		  <img src="images/peliculas/uncharted.jpg" id="image_inicio" title="Uncharted">
        <img src="images/peliculas/wayDown.jpg" id="image_inicio" title="Way Down">
        <img src="images/peliculas/clifford.jpg" id="image_inicio" title="Clifford">
        <img src="images/peliculas/frozen.jpg" id="image_inicio" title="Frozen">
        <img src="images/peliculas/luca.jpg" id="image_inicio" title="Luca">
        <img src="images/peliculas/it.jpg" id="image_inicio" title="It">
        <img src="images/peliculas/vida.jpg" id="image_inicio" title="La vida es bella">
        <img src="images/peliculas/kimetsu.jpg" id="image_inicio" title="Kimetsu no Yaiba">
        <img src="images/peliculas/campeones.jpg" id="image_inicio" title="Campeones">
        <img src="images/peliculas/elmadrileño.jpg" id="image_inicio" title="El madrileño">
    </div>
	   <br>
  </div>
  <!-- PIE DE PÁGINA -->
  <?php
  require("includes/comun/pie.html")
  ?>
</body>

</html>

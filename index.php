<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Portada';
$contenidoPrincipal=<<<EOS
  <div class="cuerpo_peliculas">

    <h1><br>Películas de las que más se habla</h1>

  	<div class="texto_inicio">
  		  <a href="ejemploPelicula.php"><img src="images/peliculas/avengers.jpg" id="image_inicio" title="Avengers"></a>
  		  <img src="images/peliculas/star_wars.jpg" id="image_inicio" title="Star Wars">
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
  </div>
  EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);




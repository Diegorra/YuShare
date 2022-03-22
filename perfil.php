<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Portada';
$contenidoPrincipal=<<<EOS
  <h1>John Doe</h1>
    <div class="card">
        <img src="images/cara1.jpg" alt="Steven Spielberg" style="width:100%">
        <h1>Steven Spielberg</h1>
        <p class="title">Director</p>
    </div>

    <div class="texto_inicio">
  		<img src="images/peliculas/avengers.jpg" id="image_inicio" title="Avengers">
        <img src="images/peliculas/vida.jpg" id="image_inicio" title="La vida es bella">
        <img src="images/peliculas/wayDown.jpg" id="image_inicio" title="Way Down">
        <img src="images/peliculas/star_wars.jpg" id="image_inicio" title="Star Wars">
    </div>

    <div class="editarPerfil">
        <a href="editarPerfil.php">Editar perfil</a>
    </div>
  EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);



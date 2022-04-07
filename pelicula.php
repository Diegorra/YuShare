<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Portada';
$contenidoPrincipal=<<<EOS
  <div class ="pelicula">
    <h1> Vengadores: Era de Ultrón</h1> 
    <img src="images/peliculas/avengers.jpg" id="image_info" title="Avengers">
    <h2> Sinopsis </h2>
    <p> Tony Stark quiere lanzar un nuevo programa de paz, pero algo sale mal y acaba creando a Ultrón, un robot que quiere destruir a la humanidad. Thor, Hulk y el resto de los Vengadores deberán juntar sus fuerzas una vez más para luchar contra el robot.</p>
    <h2>Fecha de estreno</h2>
    <p> 29 de abril de 2015 </p>
    <h2> Director</h2>
    <p> Joss Whedon </p>
    <h2> Duración</h2>
    <p> 141 min </p>
  </div>
  EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);





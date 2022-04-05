<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$tituloPagina = 'Portada';
$peliculas=Pelicula::conseguirPeliculas();
$contenidoPrincipal = 'dilo tata';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);




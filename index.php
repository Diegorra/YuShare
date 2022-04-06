<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$tituloPagina = 'Portada';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => Pelicula::conseguirPeliculas()];
$app->generaVista('/plantillas/plantilla.php', $params);



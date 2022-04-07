<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$showMovies = Pelicula::conseguirPeliculas();

$tituloPagina = 'Portada';

$contenidoPrincipal=<<<EOF
    <h1>Enseñar película</h1>
    $showMovies
EOF;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' =>  $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);



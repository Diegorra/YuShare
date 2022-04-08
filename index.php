<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$showMovies = Pelicula::conseguirPeliculas();

$tituloPagina = 'Portada';

$contenidoPrincipal=<<<EOF
    <div class="texto_inicio">
        <h1>Catálogo de películas</h1>
    </div> 
    $showMovies
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' =>  $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);



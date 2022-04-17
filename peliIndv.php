<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$infoPelicula = Pelicula::todaInfoPeliculas($_GET["id"]);

$tituloPagina = 'Info';

$contenidoPrincipal=<<<EOF
    <div class="texto_inicio">
        <h1> </h1>
    </div> 
    $infoPelicula
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);




<?php

require_once __DIR__.'/includes/config.php';

$usuarios = $app->getAtributoPeticion('usuarios');
$peliculas = $app->getAtributoPeticion('peliculas');

$tituloPagina = 'Search';

$contenidoPrincipal=<<<EOF
    $usuarios
    $peliculas
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' =>  $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

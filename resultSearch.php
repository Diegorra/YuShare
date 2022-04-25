<?php

require_once __DIR__.'/includes/config.php';

$usuarios = $app->getAtributoPeticion('usuarios');
$peliculas = $app->getAtributoPeticion('peliculas');

$tituloPagina = 'Search';

$contenidoPrincipal=<<<EOF
    <div class="texto_inicio">
        <h1>PELICULAS Y USUARIOS ENCONTRADOS</h1>
    </div> 
    $usuarios
    $peliculas
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' =>  $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

<?php

require_once __DIR__.'/includes/config.php';

$usuarios = $app->getAtributoPeticion('usuarios');
$peliculas = $app->getAtributoPeticion('peliculas');

$params = ['tituloPagina' => 'Search', 'usuarios' => $usuarios, 'peliculas' => $peliculas];
$app->generaVista('/plantillas/search.php', $params);
        

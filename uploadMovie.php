<?php

require_once __DIR__.'/includes/config.php';

$formUpload = new \es\ucm\fdi\aw\FormularioPelicula();
$formUpload = $formUpload->gestiona();

$tituloPagina = 'Upload movie';
$contenidoPrincipal=<<<EOF
  	<h1>Añadir película</h1>
    $formUpload
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
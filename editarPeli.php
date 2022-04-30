<?php

require_once __DIR__.'/includes/config.php';

$formEdit = new \es\ucm\fdi\aw\FormularioEditarPelicula();
$formEdit = $formEdit->gestiona();

$tituloPagina = 'Editar pelicula';
$contenidoPrincipal=<<<EOS
    <div class ="editar">
		<h1>Edita la película</h1>
		$formEdit
	</div>		
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
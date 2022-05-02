<?php

require_once __DIR__.'/includes/config.php';

$titulo = filter_input(INPUT_GET, 'titulo', FILTER_VALIDATE_INT);

$formEdit = new \es\ucm\fdi\aw\FormularioEditarPelicula($titulo);


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
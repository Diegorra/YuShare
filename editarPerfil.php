<?php

require_once __DIR__.'/includes/config.php';

$formSettings = new \es\ucm\fdi\aw\usuarios\FormularioSettings();
$formSettings = $formSettings->gestiona();

$tituloPagina = 'Settings';
$contenidoPrincipal=<<<EOS
    <div class ="editar">
		<h1>Edita tu perfil</h1>
		$formSettings
	</div>		
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);










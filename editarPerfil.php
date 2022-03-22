<?php

require_once __DIR__.'/includes/config.php';

$formSettings = new \es\ucm\fdi\aw\usuarios\FormularioSettings();
$formSettings = $formSettings->gestiona();

$tituloPagina = 'Portada';
$contenidoPrincipal=<<<EOS
    <div class ="editar">
		<h1>Edita tu perfil</h1>
		$formSettings
	</div>		
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);



/*
<fieldset>
			<legend>Datos del perfil</legend>
				Nombre:<br> <input type="text" name="nom"><br>
				Email:<br> <input type="text" name="email"><br>
				Nombre de usuario:<br> <input type="text" name="user"><br>
				Teléfono: <br> <input type="text" name="phone"><br>
		</fieldset>
	<input type="submit" name="aceptar">
*/







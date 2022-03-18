<?php

//Inicio del procesamiento

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioLogin.php';

$form = new FormularioLogin();

$tituloPagina = 'Login';
$contenidoPrincipal = <<<EOF
		<h1>Acceso al sistema</h1>
EOF;
$htmlFormLogin = $form->gestiona();
$contenidoPrincipal .= $htmlFormLogin;

include __DIR__.'/includes/plantillas/plantilla.php';
<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Amigo;

$allFriends = Amigo::listaAmigos($app->idUsuario());
$noFriends = Amigo::obtenerUsuarios($app->idUsuario());

$tituloPagina = 'All friends';

function muestraAmigos($friendList){
    $contenido = "";
    foreach ($friendList as $friend) {
			$estatus = "<i button class='fa-solid fa-circle-xmark deleteFriend' friendId='{$friend->getIdAmigo()}'></i>";
			$amigo = <<<EOS
			<div class="friends">
				<h2>{$friend->getNombreAmigo()} {$estatus}</h2>
			</div> 
			<p></p>
		EOS;
		$contenido .=$amigo;
	}
    return $contenido;
}

function muestraSolicitudes($friendList){
    $contenido = "";
    foreach ($friendList as $friend) {
		$estatus = "<i button class='fa-solid fa-circle-check acceptFriend' addFriendId='{$friend->getIdAmigo()}'></i>";
		$amigo = <<<EOS
		<div class="friends">
			<h2>{$friend->getNombreAmigo()} {$estatus}</h2>
		</div> 
		<p></p>
		EOS;
		$contenido .=$amigo;
    }
    return $contenido;
}

$mostrar = muestraAmigos($allFriends);
$noAmigos = muestraSolicitudes($noFriends);

$contenidoPrincipal=<<<EOF
	<div class="texto_inicio">
		<h1></h1>
		<h1></h1>
	</div>
	<div class="flexbox-container">
		<div id="contenedorAmigos">
			<h1>Lista de amigos</h1>
			{$mostrar}
		</div>
		<div id="contenedorNoAmigos">
			<h1>Solicitudes</h1>
			{$noAmigos}
		</div>
		</div>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);




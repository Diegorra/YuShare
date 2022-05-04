<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Amigos;
use es\ucm\fdi\aw\usuarios\Usuario;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$allFriends = Amigos::listaAmigos($id);
$noFriends = Amigos::obtenerUsuarios($id);

$tituloPagina = 'All friends';

function muestraAmigos($friendList){
    $contenido = "";
    foreach ($friendList as $friend) {
			$estatus = "<i button id='deleteFriend' class='fa-solid fa-circle-xmark' friendId='{$friend->getIdAmigo()}'></i>";
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
		$estatus = "<i button id='addFriend' class='fa-solid fa-circle-check' addFriendId='{$friend->getIdAmigo()}'></i>";
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




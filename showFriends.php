<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Amigos;
use es\ucm\fdi\aw\usuarios\Usuario;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$allFriends = Amigos::listaAmigos($id);

$tituloPagina = 'All friends';

function muestraInfo($friendList){
    $contenido = "";
    foreach ($friendList as $friend) {
		$borrar = "<i id='deleteFriend' friendId='{$friend->getIdAmigo()}' class='fa-solid fa-circle-xmark'></i>";
		$amigo = <<<EOS
			<div class="friends">
				<h1>{$friend->getNombreAmigo()} {$borrar}</h1>
			</div> 
			<p></p>
		EOS;
		$contenido .=$amigo;
    }
    return $contenido;
}

$mostrar = muestraInfo($allFriends);

$contenidoPrincipal=<<<EOF
    <div class="texto_inicio">
	<h1>Lista de amigos</h1>
	<h1>{$mostrar}</h1>
    </div> 
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);



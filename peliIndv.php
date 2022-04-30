<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$idPeli = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$infoPelicula = Pelicula::todaInfoPeliculas($idPeli);

if($app->usuarioLogueado()){
  $editar = "<a href= 'editarPeli.php' class='botonEditarPerfil'> Editar película</a>";
}else{
  $editar = "";
}

$tituloPagina = 'Info';

$contenidoPrincipal=<<<EOF
    <div class="texto_inicio">
        <h1> </h1>
    </div> 
    $editar
    $infoPelicula
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);




<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$peliculasUsuario = Pelicula::peliculasPerfil($app->idUsuario());
$tituloPagina = 'Perfil';
$contenidoPrincipal=<<<EOS
  <h1>.</h1>
    <div class="card">
        <img src="images/cara1.jpg" alt="{$app->nombreUsuario()}" style="width:50%">
        <h1>{$app->nombreUsuario()}</h1>
        <p class="title">Director</p>
    </div>
    <div class="texto_inicio">
      $peliculasUsuario
    </div>
  
  
  

  EOS;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

/*


    <div class="editarPerfil">
        <a href="editarPerfil.php">Editar perfil</a>
    </div>


*/
?>

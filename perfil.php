<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;
use es\ucm\fdi\aw\usuarios\Usuario;
$usuario = Usuario::buscaUsuario($app->nombreUsuario());
$peliculasUsuario = Pelicula::peliculasPerfil($app->idUsuario());
$tituloPagina = 'Perfil';
$contenidoPrincipal=<<<EOS
  <h1>.</h1>
  <h1>.</h1>
    <div class='card'>
        <img src='{$usuario->getImage()}' id="image_perfil">

        <br><br><br><br><br><br><br><br><br><br>
        <a href= "editarPerfil.php" class="botonEditarPerfil"> Editar perfil</a>
        </div>
        <div class='cardRightText'>
          <h1>{$usuario->getNombreUsuario()}</h1>
          <h1>{$usuario->getEmail()}</h1>
          <p class="title">Director</p>
        </div>
        
    
    <div class="texto_perfil">
    <p> Tus películas: </p>
      $peliculasUsuario
    </div>
  
  
  

  EOS;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

/*<div class="card">


    <div class="editarPerfil">
        <a href="editarPerfil.php">Editar perfil</a>
    </div>


*/
?>

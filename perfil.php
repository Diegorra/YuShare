<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;
use es\ucm\fdi\aw\usuarios\Usuario;


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$usuario = Usuario::buscaPorId($id);
$peliculasUsuario = Pelicula::peliculasPerfil($usuario->getId());

if($usuario->getId() == $app->idUsuario()){
  $settings = "<a href= 'editarPerfil.php' class='botonEditarPerfil'> Editar perfil</a>";
}else{
  $settings = "";
}

$tituloPagina = 'Perfil';
$contenidoPrincipal=<<<EOD
  <h1>.</h1>
  <h1>.</h1>
  <div class='card'>
    <img src='{$usuario->getImage()}' id="image_perfil">
    <br><br><br><br><br><br><br><br><br><br>
    {$settings}
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
  
  
  

  EOD;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

/*<div class="card">


    <div class="editarPerfil">
        <a href="editarPerfil.php">Editar perfil</a>
    </div>


*/
?>

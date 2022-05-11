<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;
use es\ucm\fdi\aw\Amigo;
use es\ucm\fdi\aw\usuarios\Usuario;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$usuario = Usuario::buscaPorId($id);
$listaPeliculas = Pelicula::peliculasPerfil($usuario->getId());
$settings = "";

function muestraPeliculas($filmList, $app){
  $contenido= "";
    foreach ($filmList as $film) {
        $peliculaUrl = $app->buildUrl('/peliIndv.php', ['id'=> $film->getId()]);
        $peli = <<<EOS
            <div class="indexPeliculas">
                <a href="{$peliculaUrl}">
                    <img src="{$film->getSrc()}" id="image_inicio" alt="img_perfil">
                </a>
            </div> 
        EOS;
        $contenido .=$peli;
    }
    return $contenido;
}

if($usuario->getId() == $app->idUsuario()){
    $settings = "<a href= 'editarPerfil.php' class='botonEditarPerfil'>Editar perfil</a>";
    $amigoUrl = $app->resuelve('/showFriends.php');
    $manageFriends = "<p></p><a href= '$amigoUrl' class='botonEditarPerfil'>Gestionar amigos</a>";
    $deleteProfile = "<p></p><a id='deleteProfile' class='botonEditarPerfil' href='index.php'>Borrar Perfil</a>";
    $settings .= $manageFriends . $deleteProfile;
}else{
  if($app->usuarioLogueado()) {
    if(Amigo::esAmigo($usuario->getId(), $app->idUsuario())) {  
      $settings = "<button id='deleteFriend' class='botonEditarPerfil deleteFriend' friendId='{$usuario->getId()}'>Desagregar</button>";
    }else {
      $settings = "<button id='addFriend' class='botonEditarPerfil' addFriendId='{$usuario->getId()}'>Agregar</button>";
    }
  }
}

$peliculasUsuario = muestraPeliculas($listaPeliculas, $app);

$tituloPagina = 'Perfil';

$contenidoPrincipal=<<<EOD
  <h1>.</h1>
  <h1 style="color: black">.</h1>
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
?>

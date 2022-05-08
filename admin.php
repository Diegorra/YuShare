<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\usuarios\Usuario;

$tituloPagina = 'Admin';

function muestraUsuario(){
  $list = Usuario::Usuarios();
  $html= "";
  foreach ($list as $usuario) {
    
    if($usuario->getEnabled()){
      $enabled = "<span style='font-size: 2em; color: green;'><i class='fa-solid fa-check fa-beat'></i></span>";
      $button = "<button class='ban' type='button' idU='{$usuario->id}'><span style='vertical-align: top; font-size: 1.5em; color: Tomato;'>
      <i class='fa-solid fa-ban fa-border fa-fw '></i></span></button>";
    }else{
      $enabled = "<span style='font-size: 2em; color: red;'><i class='fa-solid fa-xmark fa-beat'></i></span>";
      $button = "<button class='ban' type='button' idU='{$usuario->id}'><span style='vertical-align: top; font-size: 1.5em; color: Mediumslateblue;'>
      <i class='fa-solid fa-circle-check fa-border fa-fw'></i></span></button>";
    }
    
    $userHtml = <<<EOS
      <tr>
        <td>{$usuario->getNombreUsuario()}</td>
        <td>{$usuario->getEmail()}</td>
        <td>{$enabled}</td>
        <td>
          <div class="btn-group">
            <button class="deleteU" type="button"  idU="{$usuario->id}"><span style='vertical-align: top; font-size: 1.5em; color: yellow;'>
            <i class='fa-solid fa-trash-can fa-border fa-fw'></i></span></button>
            $button
          </div>
        </td>
      </tr>
    EOS;
    $html .= $userHtml;
  }
  return $html;
}

if (!$app->tieneRol("ADMIN_ROLE")) {
  $contenidoPrincipal=<<<EOS
  <h1>Acceso Denegado!</h1>
  <p>No tienes permisos suficientes para administrar la web.</p>
  EOS;
} else {
  //Administramos!!
  $muestraUsuarios = muestraUsuario();
  $contenidoPrincipal=<<<EOS
    <h1>Administración Usuarios</h1>
    <table class="table" border="1" width="100%">
      <tr>
        <th>UserName</th>
        <th>email</th>
        <th>Enabled</th>
        <th>Actions</th>
      </tr>
      $muestraUsuarios
    </table>
  EOS;
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>

<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\usuarios\Usuario;

$tituloPagina = 'Admin';

function muestraUsuario(){
  $list = Usuario::Usuarios();
  $html= "";
  foreach ($list as $usuario) {
    
    if($usuario->getEnabled()){
      $enabled = "<i class='fa-solid fa-check'></i>";
      $button = "<button class='ban' type='button' idU='{$usuario->id}'><i class='fa-solid fa-ban'></i></button>";
    }else{
      $enabled = "<i class='fa-solid fa-xmark'></i>";
      $button = "<button class='ban' type='button' idU='{$usuario->id}'><i class='fa-solid fa-circle-check'></i></button>";
    }
    
    $userHtml = <<<EOS
      <tr>
        <td>{$usuario->getNombreUsuario()}</td>
        <td>{$usuario->getEmail()}</td>
        <td>{$enabled}</td>
        <td>
          <div class="btn-group">
            <button class="deleteU" type="button"  idU="{$usuario->id}"><i class='fa-solid fa-trash-can'></i></button>
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

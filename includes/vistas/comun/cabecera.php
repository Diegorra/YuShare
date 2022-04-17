<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\FormularioLogout;
use es\ucm\fdi\aw\FormularioPelicula;


function menu()
{
    $html = '';
    $app = Aplicacion::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();
        
        // formulario peli va aqui en la version final
        //$formLogout = new FormularioLogout();
        //$htmlLogout = $formLogout->gestiona();
        
        $perfilUrl = $app->buildUrl('/perfil.php', ['id'=> $app->idUsuario()]);
        $subirPelicula = $app->resuelve('/uploadMovie.php');
        $logout = $app->resuelve('/logout.php');


        $html = <<<EOS
            <a href='{$perfilUrl}'>$nombreUsuario</a>
            <a href="{$subirPelicula}"> Subir pelicula</a>
            <a href='{$logout}'>LogOut</a>

        EOS;
    } else {
        $loginUrl = $app->resuelve('/login.php');
        $registroUrl = $app->resuelve('/registro.php');

        $html = <<<EOS
        <a href="{$loginUrl}">Login</a> 
        <a href="{$registroUrl}">Registro</a>
      EOS;
    }

    return $html;

}
?>
<header>
    <div class="cabecera">
        <a href="index.php" title="YouShare"><img src="images/granlogo.png" id="logo-cabecera"></a>
        <?php
        require_once 'includes/config.php';
        ?>
        <div id="enlaces">            
            <?= menu(); ?>
        </div>
    </div>
</header>

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


        $html = <<<EOS
            <a href='{$perfilUrl}'><i class="fa-solid fa-user"></i></a>
            <a href="{$subirPelicula}"><i class="fa-solid fa-arrow-up-from-bracket"></i></a>
            <a id="logout" href=""><i class="fa-solid fa-arrow-right-from-bracket"></i></a>

        EOS;
        if($app->esAdmin()){
            $adminUrl = $app->resuelve('/admin.php');
            $html .= "<a href='{$adminUrl}'>Admin</a>";
        }
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
        <a href="index.php" title="YouShare"><img src="images/granlogo.png" id="logo-cabecera" alt="Logo"></a>
        <?php
        require_once 'includes/config.php';
        ?>
        <div id="enlaces">            
            <?= menu(); ?>
        </div>
    </div>
</header>

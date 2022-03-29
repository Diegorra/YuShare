<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\FormularioLogout;

function menu()
{
    $html = '';
    $app = Aplicacion::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();

        $formLogout = new FormularioLogout();
        $htmlLogout = $formLogout->gestiona();
        $perfilUrl = $app->resuelve('/perfil.php');
        $html = "<a href='{$perfilUrl}'>Perfil </a> $htmlLogout";
    } else {
        $loginUrl = $app->resuelve('/login.php');
        $registroUrl = $app->resuelve('/registro.php');
        $html = <<<EOS
        <a href="{$loginUrl}">Login</a> <a href="{$registroUrl}">Registro</a>
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

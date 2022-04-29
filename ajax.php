<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;


if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'deleteFilm':
                Pelicula::borrarPeli($_POST['id'], $_POST['userID']);
                $app->redirige('/yushare/index.php');
                break;
            case 'logout':
                $app->logout();
                break;
            case 'editFilm':
                Pelicula::editarPeli($_POST['id'], $_POST['userID']);
                $app->redirige('/yushare/perfil.php');
                break;
            default:
                break;
            }
}

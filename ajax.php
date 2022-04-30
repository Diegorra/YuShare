<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;
use es\ucm\fdi\aw\usuarios\Usuario;


if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'deleteFilm':
                Pelicula::borrarPeli($_POST['id'], $app->idUsuario());
                break;
            case 'deleteUser':
                Usuario::borraPorId($_POST['id']);
                break;
            case 'logout':
                $app->logout();
                break;
            default:
                break;
            }
}

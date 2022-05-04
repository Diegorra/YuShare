<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;
use es\ucm\fdi\aw\Amigos;
use es\ucm\fdi\aw\usuarios\Usuario;

if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'deleteFilm':
                Pelicula::borrarPeli($_POST['id'], $app->idUsuario());
                break;
			case 'deleteFriend':
                Amigos::borrarAmigo($_POST['id'], $app->idUsuario());
                break;
            case 'addFriend':
                Amigos::agregarAmigo($_POST['id'], $app->idUsuario());
                break;
            case 'deleteUser':
                Usuario::borraPorId($_POST['id']);
                break;
            case 'ban':
                Usuario::updateEnabled($_POST['id']);
                break;
            case 'logout':
                $app->logout();
                break;
            default:
                break;
            }
}

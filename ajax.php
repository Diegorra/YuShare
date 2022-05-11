<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;
use es\ucm\fdi\aw\Amigo;
use es\ucm\fdi\aw\usuarios\Usuario;

if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'deleteFilm':
                Pelicula::borrarPeli($_POST['id'], $app->idUsuario());
                break;
            case 'addFriend':
                 Amigo::peticionAmistad($_POST['id'], $app->idUsuario()); //amigo y usuario
                break;
			case 'deleteFriend':
                Amigo::borraAmigo($_POST['id'], $app->idUsuario());
                break;
            case 'acceptFriend':
                Amigo::agregarAmigo($_POST['id'], $app->idUsuario());
                break;
            case 'deleteUser':
                Usuario::borraPorId($_POST['id']);
                break;
            case 'deleteProfile':
                $id = $app->idUsuario();
                $app->logout();
                Usuario::borraPorId($id);
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

<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;


if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'deleteFilm':
                Pelicula::borrarPeli($_POST['id'], $_POST['userID']);
                break;
            case 'logout':
                $app->logout();
                break;
            default:
                break;
            }
        $app->redirige('/yushare/index.php');
}


/*
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$idUser = filter_input(INPUT_GET, 'idUser', FILTER_VALIDATE_INT);
*/
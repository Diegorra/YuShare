<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$idUser = filter_input(INPUT_GET, 'idUser', FILTER_VALIDATE_INT);

Pelicula::borrarPeli($id, $idUser);
$app->redirige('/yushare/index.php');
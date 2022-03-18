<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
  <title>YouShare</title>
  <link rel="stylesheet" type="text/css" href="style/style.css">
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="images/minilogo.png">
</head>

<body>

<?php

//Inicio del procesamiento
require_once __DIR__.'/includes/config.php';

//Doble seguridad: unset + destroy
unset($_SESSION["login"]);
unset($_SESSION["esAdmin"]);
unset($_SESSION["nombre"]);


session_destroy();
session_start();
$tituloPagina = 'Logout';
$contenidoPrincipal = <<<EOF
		<h1>Hasta pronto!</h1>
EOF;

include __DIR__.'/includes/plantillas/plantilla.php';

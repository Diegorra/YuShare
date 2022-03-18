<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
  <title>YouShare</title>
  <link rel="stylesheet" type="text/css" href="style/style.css">
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="images/minilogo.png">
</head>

<body>
  <!-- CABECERA DE LA PÁGINA CON IMAGEN Y MENÚ -->
  <?php
    require("includes/comun/cabecera.php");
    require("includes/comun/search.php")
  ?>

  <?php

//Inicio del procesamiento

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioLogin.php';

$form = new FormularioLogin();

$tituloPagina = 'Login';
$contenidoPrincipal = <<<EOF
		<h1>Acceso al sistema</h1>
EOF;
$htmlFormLogin = $form->gestiona();
$contenidoPrincipal .= $htmlFormLogin;

include __DIR__.'/includes/plantillas/plantilla.php';

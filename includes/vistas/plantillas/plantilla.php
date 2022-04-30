<!DOCTYPE html>
<?php
$params['app']->doInclude('/vistas/helpers/plantilla.php');
$mensajes = mensajesPeticionAnterior();
?>
<html lang="es" dir="ltr">
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/style.css') ?>" />
	<script type="text/javascript" src="<?= $params['app']->resuelve('/js/jquery-3.6.0.min.js') ?>"></script>
	<script type="text/javascript"  src="<?= $params['app']->resuelve('/js/actions.js') ?>"></script>
	<script src="https://kit.fontawesome.com/233f0610d6.js" crossorigin="anonymous"></script>
	<link rel="icon" type="image/png" href="images/minilogo.png">
</head>
<body>
<?= $mensajes ?>
<div id="contenedor">
<?php
$params['app']->doInclude('/vistas/comun/cabecera.php');
if($params['tituloPagina'] === 'Portada'){
	$params['app']->doInclude('/vistas/comun/searchBar.php');
}
?>
	<main>
		<article>
			<?= $params['contenidoPrincipal'] ?>
		</article>
	</main>
<?php
$params['app']->doInclude('/vistas/comun/pie.php');
?>
</div>
</body>
</html>

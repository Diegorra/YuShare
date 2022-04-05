<?php
$params['app']->doInclude('/vistas/helpers/plantilla.php');
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/style.css') ?>" />
	<link rel="icon" type="image/png" href="images/minilogo.png">
</head>
<body>
<div id="contenedor3">
<?php
$params['app']->doInclude('/vistas/comun/cabecera.php');
$params['app']->doInclude('/vistas/comun/search.php');
?>
	<main>
		<article>
			<?php
                if(($params['usuarios'] === null && $params['peliculas'] === null) || count($params['usuarios']) == 0 && count($params['peliculas']) == 0){
                    echo "<p>No se han encontrado resultados :(</p>";
                }else{
                    foreach ($params['usuarios'] as $usuario) {
                        echo"<p>{$usuario->getNombreUsuario()}</p>";
                    }
                    foreach($params['peliculas'] as $pelicula){
                        echo"<p>{$pelicula->getTitulo()}</p>";
                    }
                }
            ?>
		</article>
	</main>
<?php
$params['app']->doInclude('/vistas/comun/pie.php');
?>
</div>
</body>
</html>

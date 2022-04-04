<?php
$params['app']->doInclude('/vistas/helpers/plantilla.php');
$usuarios = $params['app']->getAtributoPeticion('usuarios');
$peliculas = $params['app']->getAtributoPeticion('peliculas');
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
<div id="contenedor">
<?php
$params['app']->doInclude('/vistas/comun/cabecera.php');
if($params['tituloPagina'] === 'Portada'){
	$params['app']->doInclude('/vistas/comun/search.php');
}
?>
	<main>
		<article>
			<?php
                if($usuarios === null || $peliculas === null){
                    echo "<p>No se han encontrado resultados :(</p>"
                }else{
                    foreach ($usuarios as $usuario) {
                        echo "<p>{$usuario.getNombreUsuario()}</p>";
                    }
                    foreach($peliculas as $pelicula){
                        echo "<p>{$pelicula.getTitulo()}</p>";
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

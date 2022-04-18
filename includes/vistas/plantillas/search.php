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
$params['app']->doInclude('/vistas/comun/searchBar.php');


?>
	<main>
		<article>
			<?php
                if(($params['usuarios'] === null && $params['peliculas'] === null) || count($params['usuarios']) == 0 && count($params['peliculas']) == 0){
                    echo "<h2>No se han encontrado resultados :(</h2>";
                }else{
                    foreach ($params['usuarios'] as $usuario) {
                        echo"<h1>Usuario: {$usuario->getNombreUsuario()}</h1>";
                    }
                    foreach($params['peliculas'] as $pelicula){
                        echo"<h1>Titulo: {$pelicula->getTitulo()}</h1>";
                    }
                }
            ?>
		</article>
	</main>
    <?php
    foreach($params['peliculas'] as $pelicula){ 
        echo"<h2>Genero: {$pelicula->getGenero()}</h2>";
        echo"<h2>Likes: {$pelicula->getNumLikes()}</h2>";     
echo"<h2>{$pelicula->getText()}</h2>";
echo"<p><img src='{$pelicula->getSrc()}'id='image_info'></p>";
echo"<h2>Trailer: <iframe width='560' height='315' src='{$pelicula->getTraile()}' frameborder='0' allowfullscreen></iframe></h2>";       

}
 ?>
 <?php
 foreach($params['usuarios'] as $usuario){
    echo"<h2>Email: {$usuario->getEmail()}</h2>";
    echo"<h2>Rol: {$usuario->getRole()}</h2>";
    echo"<p><img src='{$usuario->getImage()}'id='image_info'></p>";
 }?>
 


<?php
$params['app']->doInclude('/vistas/comun/pie.php');
?>
</div>
</body>
</html>

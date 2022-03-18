<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
  <title>YouShare</title>
  <link rel="stylesheet" type="text/css" href="style/style.css">
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="images/minilogo.png">
</head>
	<?php
	    require("includes/comun/cabecera.php");
	    require("includes/comun/search.php")
  	?>
<body>
	  <div class ="editar">
		<h1> Edita tu perfil </h1>
		<fieldset>
			<legend>Datos del perfil</legend>
				Nombre:<br> <input type="text" name="nom"><br>
				Email:<br> <input type="text" name="email"><br>
				Nombre de usuario:<br> <input type="text" name="user"><br>
				Teléfono: <br> <input type="text" name="phone"><br>
		</fieldset>
	<input type="submit" name="aceptar">	
	</form>
</body>
</html>
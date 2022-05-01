<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$idPeli = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$infoPelicula = Pelicula::todaInfoPeliculas($idPeli); // devuelve true si ha ido ok

if($app->usuarioLogueado()) {
  $editar = "<a href= 'editarPeli.php' class='botonEditarPerfil'> Editar película</a>";
}
else{
  $editar = "";
}

$tituloPagina = 'Info';

function muestraInfo($filmList, $app){
    $contenido= "";
    foreach ($filmList as $film) {
        $peli = <<<EOS
                    <table border="1" width="100%">
                    <tr>
                        <th width="30%">Genero</th>
                        <th width="32%">Sinopsis</th>
                        <th width="47%"></th>
                        <th width="40%"></th>
                    </tr>
                    <div class ="pelicula">
                        <h1>{$film->getTitulo()}</h1>
                    </div>
                    <td><h2><small>{$film->getGenero()}</small></h2></td>
                    <td><h2><small>{$film->getText()}</small></h2></td>
                    <td><p><img src="{$film->getSrc()}"id="image_info" alt="img_indv"></p></td>
                    <td><p><iframe width="560" height="315" src="{$film->getTrailer()}" frameborder="0" allowfullscreen></iframe></p></td>
                </table>
        EOS;
        $contenido .=$peli;
    }
    return $contenido;
}

$muestraP = muestraInfo($infoPelicula, $app);

$contenidoPrincipal=<<<EOF
    <div class="texto_inicio">
        <h1></h1>
    </div> 
    $editar
    $muestraP
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);




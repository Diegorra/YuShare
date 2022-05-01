<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;

$showMovies = Pelicula::conseguirPeliculas();

$tituloPagina = 'Portada';

function muestraPeliculas($filmList, $app){
    $contenido= "";
    foreach ($filmList as $film) {
        $peliculaUrl = $app->buildUrl('/peliIndv.php', ['id'=> $film->getId()]);
        $peli = <<<EOS
            <div class="indexPeliculas">
                <a href="{$peliculaUrl}">
                    <img src="{$film->getSrc()}" id="image_inicio" alt="img_index">
                </a>
            </div> 
        EOS;
        $contenido .=$peli;
    }
    return $contenido;
}

$muestraP = muestraPeliculas($showMovies, $app);

$contenidoPrincipal=<<<EOF
    <div class="texto_inicio">
        <h1>Catálogo de películas</h1>
    </div> 
    $muestraP
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' =>  $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);



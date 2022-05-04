<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Pelicula;

$usuarios = $app->getAtributoPeticion('usuarios');
$peliculas = $app->getAtributoPeticion('peliculas');

$tituloPagina = 'Search';

function muestraUsuarios($userList, $app){
    $contenido = "<h1>". strval(count($userList)) . " resultados para usuarios del sistema</h1>";
    foreach ($userList as $user) {
        $perfilUrl = $app->buildUrl('/perfil.php', ['id'=> $user->getId()]);
        $usuario = <<<EOS
            <div class="search">
                <a href="{$perfilUrl}">
                    <img src="{$user->getImage()}" id="imgU_search" alt="profilePic">
                    <h1>{$user->getNombreUsuario()}</h1>
                </a>
            </div> 
            <p></p>
        EOS;
        $contenido .=$usuario;
    }
    return $contenido;
}

function muestraPeliculas($filmList, $app){
    $contenido= "<h1>" . strval(count($filmList)) . " resultados para peliculas del sistema</h1>";
    foreach ($filmList as $film) {
        $peliculaUrl = $app->buildUrl('/peliIndv.php', ['id'=> $film->getId()]);
        $peli = <<<EOS
            <div class="search">
                <a href="{$peliculaUrl}">
                    <img src="{$film->getSrc()}" id="imgU_search" alt="img_search">
                    <h1>{$film->getTitulo()}</h1>
                </a>
            </div> 
            <p></p>
        EOS;
        $contenido .=$peli;
    }
    return $contenido;
}

$muestraU = muestraUsuarios($usuarios, $app);
$muestraP = muestraPeliculas($peliculas, $app);

$contenidoPrincipal=<<<EOF
    <div class="texto_search">
        <h1>PELICULAS Y USUARIOS ENCONTRADOS</h1>
    </div> 
    $muestraU
    $muestraP
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' =>  $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

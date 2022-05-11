<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Comentario;
use es\ucm\fdi\aw\Aplicacion;


$app = Aplicacion::getInstance();
$idPeli = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$infoPelicula = Pelicula::todaInfoPeliculas($idPeli);
$formComent = "";

if($app->usuarioLogueado()){
    $formComent = new \es\ucm\fdi\aw\FormularioComent($idPeli);
    $formComent = $formComent->gestiona();
}

$tituloPagina = 'Info';

function mostrarComentarios()
{
    $idPeli = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $comentarios = Comentario::mostrarComentarios($idPeli);
    $app = Aplicacion::getInstance();
    //HTML: https://codepen.io/Creaticode/pen/yLWqXo
    if(count($comentarios) > 0){
    $htmlComentarios = <<<EOT
    <h1>Comentarios sobre la película</h1>
    <div class="comments-container">
    <ul id="comments-list" class="comments-list">
    <li>
    EOT;

    foreach($comentarios as $comentario) {
        $usuario = Usuario::buscaPorId($comentario->getIdUsuario());
        $htmlComentarios=$htmlComentarios.<<<EOF
            <div class="comment-main-level">
                <!-- Avatar -->
                <!-- Contenedor del Comentario -->
                <div class="comment-box">
                    <div class="comment-head">
                        <h6 class="comment-name by-author"><img src="{$usuario->getImage()}" alt="" class="comment-imagen"><a>{$usuario->getNombreUsuario()}</a></h6>
                    </div>
                    <div class="comment-content">
                        {$comentario->getText()}
                    </div>
                </div>
                <p></p>
            </div>   
        EOF;
    }

    $htmlComentarios=$htmlComentarios.<<<EOT
        </li>
        </ul>
        </div>
    EOT;
}

    return $htmlComentarios;
}

function muestraInfo($film){
    $peli = <<<EOS
                <table width="100%">
                <tr>
                <th width="25%"></th>
                <th width="10%"></th>
                <th width="25%"></th>
                <th width="25%"></th>
                </tr>
                <div class ="pelicula">
                    <h1>{$film->getTitulo()}</h1>
                </div>
                <td><img src="{$film->getSrc()}"id="image_info" alt="img_indv"></td>

                <td><h3>{$film->getGenero()}</h3></td>
                <td><h3>{$film->getText()}</h3></td>
                <td><p><iframe width="500" height="315" src="{$film->getTrailer()}" frameborder="0" allowfullscreen></iframe></p></td>
                </table>
    EOS;
    return $peli;
}

$editar = "";
$borrar = "";

if($infoPelicula !== ""){
    $muestraP = muestraInfo($infoPelicula);
    if($app->idUsuario() === $infoPelicula->getIdUser()) {
        $peliculaUrl = $app->buildUrl('/editarPeli.php', ['titulo'=> $infoPelicula->getTitulo()]);
        $editar = "<a href= '{$peliculaUrl}' class='botonEditarPerfil'> Editar película</a>";
    }

    if($app->idUsuario() === $infoPelicula->getIdUser() || $app->esAdmin()){
        $borrar = "<button id='deleteFilm' class ='botonEditarPerfil' type='button' filmId='{$idPeli}'>Borrar</button>";
    }

}else{
    $muestraP = "An error took place :(";
    
}
$comentarios = mostrarComentarios();

$contenidoPrincipal=<<<EOF
    <div class="texto_inicio">
        <h1></h1>
    </div> 
    <div class="botones">
        $editar
        $borrar
    </div>
    <div class="contenedor">
        $muestraP
    <div>
    

    <h2>Añade tu comentario!<h2>
    $formComent
    
    $comentarios
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);




<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Pelicula;
use es\ucm\fdi\aw\Comentario;

$idPeli = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$infoPelicula = Pelicula::todaInfoPeliculas($idPeli);

$formComent = new \es\ucm\fdi\aw\FormularioComent;
$formComent = $formComent->gestiona();
$comentarios = Comentario::mostrarComentarios($idPeli);

$tituloPagina = 'Info';

function mostrarComentarios()
{
    //HTML: https://codepen.io/Creaticode/pen/yLWqXo

    $htmlComentarios=<<<EOF

    <div class="comments-container">
    <h1>Comentarios <a href="http://creaticode.com">creaticode.com</a></h1>

    <ul id="comments-list" class="comments-list">
        <li>
            <div class="comment-main-level">
                <!-- Avatar -->
                <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_1_zps8e1c80cd.jpg" alt=""></div>
                <!-- Contenedor del Comentario -->
                <div class="comment-box">
                    <div class="comment-head">
                        <h6 class="comment-name by-author"><a href="http://creaticode.com/blog">Agustin Ortiz</a></h6>
                        <span>hace 20 minutos</span>
                        <i class="fa fa-reply"></i>
                        <i class="fa fa-heart"></i>
                    </div>
                    <div class="comment-content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                    </div>
                </div>
            </div>   
        </li>
    </ul>

    </div>

    EOF;
    return $htmlComentarios;
}

function muestraInfo($film){
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
    $muestraP
    
    $formComent
    $comentarios
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);




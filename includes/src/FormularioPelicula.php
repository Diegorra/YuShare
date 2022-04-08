<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Pelicula;

class FormularioPelicula extends Formulario
{
    public function __construct() {
        parent::__construct('formUpload', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $idUsuario = $datos['idUsuario'] ?? '';
        $titulo = $datos['titulo'] ?? '';
        $sinopsis = $datos['sinopsis'] ?? '';
        $genero = $datos['genero'] ?? '';
        $trailer = $datos['trailer'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['idUsuario', 'titulo', 'sinopsis','genero', 'trailer'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro</legend>
            <div>
                <label for="idUsuario">ID de usuario:</label>
                <input id="idUsuario" type="text" name="idUsuario" value="$idUsuario" />
                {$erroresCampos['idUsuario']}
            </div>
            <div>
                <label for="titulo">Titulo: </label>
                <input id="titulo" type="titulo" name="titulo" />
                {$erroresCampos['titulo']}

            </div>
            <div>
                <label for="sinopsis">Sinopsis: </label>
                <input id="sinopsis" type="sinopsis" name="sinopsis" />
                {$erroresCampos['sinopsis']}

            </div>
            <div>
                <label for="genero">Género: </label>
                <input id="genero" type="genero" name="genero" />
                {$erroresCampos['genero']}

            </div>
            <div>
                <label for="trailer">Trailer: </label>
                <input id="trailer" type="trailer" name="trailer" />
                {$erroresCampos['trailer']}

            </div>
            <div>
                <button type="submit" name="registro">Subir película</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $idUsuario = trim($datos['idUsuario'] ?? '');
        $idUsuario = filter_var($idUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $idUsuario) {
            $this->errores['idUsuario'] = 'Introduce ID de usuario';
        }

        $titulo = trim($datos['titulo'] ?? '');
        $titulo = filter_var($titulo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $titulo) {
            $this->errores['titulo'] = 'Introduce un título para la película';
        }

        $sinopsis = trim($datos['sinopsis'] ?? '');
        $sinopsis = filter_var($sinopsis, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $sinopsis) {
            $this->errores['sinopsis'] = 'Introduce una sinopsis para la película';
        }

        $genero = trim($datos['genero'] ?? '');
        $genero = filter_var($genero, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $genero || ($genero != "Aventuras" && $genero != "Comedia" && $genero != "Drama" && $genero != "Terror"
            && $genero != "Musical" && $genero != "Documental")) {
            $this->errores['genero'] = 'Introduce un género para la película. Los géneros disponibles son: Acción, Aventuras, Comedia, Drama, Ciencia_Ficción, Musical, Documental.';
        }

        /*$file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];

        if(isset($_FILES['image'])){
          $file_ext= strtolower(end(explode('.',$_FILES['image']['name'])));
          $expensions= array("jpeg","jpg","png");
          if(in_array($file_ext,$expensions) === false){
                $this->errores['file'] ="extension not allowed, please choose a JPEG or PNG file.";
            }
        }*/

        $trailer = trim($datos['trailer'] ?? '');
        $trailer = filter_var($trailer, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $trailer || empty($trailer)) {
            $this->errores['trailer'] = 'Introduce un link de un vídeo para el trailer de la película';
        }

        if (count($this->errores) === 0) {
            $pelicula = Pelicula::buscaPeliculas($titulo);
            if ($pelicula) {
                $this->errores[] = "La película ya existe";
            } else {
                $pelicula = Pelicula::subirPelicula($idUsuario, $titulo, $sinopsis, $genero, $trailer);
                //move_uploaded_file($file_tmp,"images/peliculas/".$file_name);
                $app = Aplicacion::getInstance();
            }
        }
    }
}
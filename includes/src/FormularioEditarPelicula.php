<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Pelicula;

class FormularioEditarPelicula extends Formulario{
    
    private $titulo;

    public function __construct() {
        $this->titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);

        parent::__construct('formEdit', 
        [
            'formId' => "editMovie",
            'enctype' => "multipart/form-data",
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $pelicula = Pelicula::buscaPelicula($this->titulo);

        $idPeli = $pelicula->getId();
        $tituloOriginal = $pelicula->getTitulo();
        $sinopsisOriginal = $pelicula->getText();
        $generoOriginal = $pelicula->getGenero();
        $imagenOriginal = $pelicula->getSrc();
        $trailerOriginal = $pelicula->getTrailer();

        $idUsuario = $datos['idUsuario'] ?? '';
        $titulo = $datos['titulo'] ?? '';
        $sinopsis = $datos['sinopsis'] ?? '';
        $genero = $datos['genero'] ?? '';
        $src = $datos['src'] ?? '';
        $trailer = $datos['trailer'] ?? '';


        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'sinopsis','genero', 'file', 'trailer'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos de la película</legend>
            <div>
                <label for="titulo">Titulo: </label>
                <input id="titulo" type="text" name="titulo" value="$tituloOriginal" />
                {$erroresCampos['titulo']}
            </div>
            <div>
                <label for="sinopsis">Sinopsis: </label>
                <textarea id="sinopsis" type="text" name="sinopsis">{$sinopsisOriginal}</textarea>
                {$erroresCampos['sinopsis']}

            </div>
            <div>
                <label for="genero">Género: </label>
                <input id="genero" type="text" name="genero" value="$generoOriginal"/>
                {$erroresCampos['genero']}
            </div>
            <div>
                <label for="file">Photo: </label>
                <input type="file" id="file" name="file" accept="image/png, image/jpeg"/>
                {$erroresCampos['file']}
            </div>
            <div>
                <label for="trailer">Trailer: </label>
                <input id="trailer" type="text" name="trailer" value="$trailerOriginal"/>
                {$erroresCampos['trailer']}
            </div>
            <img id="imagePreview" src="$imagenOriginal" style="max-width: 300px"/>
            <div>
                <button type="submit" name="registro">Editar película</button>
            </div>
        </fieldset>
        
        EOF;
        return $html;
    }
    
    protected function procesaFormulario(&$datos)
    {
        //obtenemos datos de la película
        $pelicula = Pelicula::buscaPelicula($this->titulo);
        if($pelicula != null){
            $idPeli = $pelicula->getId();
            $tituloOriginal = $pelicula->getTitulo();
            $sinopsisOriginal = $pelicula->getText();
            $generoOriginal = $pelicula->getGenero();
            $imagenOriginal = $pelicula->getSrc();
            $trailerOriginal = $pelicula->getTrailer();
        
            $cambiarTitulo = false;
            $cambiarSinopsis = false;
            $cambiarGenero = false;
            $cambiarTrailer = false;

            $this->errores = [];

            $tituloForm = trim($datos['titulo'] ?? '');
            $tituloForm = filter_var($tituloForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

             if ($tituloForm !=='') { 
                $cambiarTitulo = true;
            }

            $sinopsisForm = trim($datos['sinopsis'] ?? '');
            $sinopsisForm = filter_var($sinopsisForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( $tituloForm !=='') {
                $cambiarSinopsis = true;
            }

            $generoForm = trim($datos['genero'] ?? '');
            $generoForm = filter_var($generoForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($generoForm  !== '') {
                $cambiarGenero = true;
                if ($generoForm != "Aventuras" && $generoForm != "Comedia" && $generoForm != "Drama" && $generoForm != "Terror"
                    && $generoForm != "Musical" && $generoForm != "Documental") {
                    $this->errores['genero'] = 'Introduce un género para la película. Los géneros disponibles son: Acción, Aventuras, Comedia, Drama, Ciencia_Ficción, Musical, Documental.';
                }
            }
            
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file = "images/peliculas/".$file_name;
            
            if($_FILES['file']['name'] == null){
                $file = $imagenOriginal;
            }

            $trailerForm = trim($datos['trailer'] ?? '');
            $trailerForm = filter_var($trailerForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($trailerForm  !== '') {
                $cambiarTrailer = true;
            }

            if (count($this->errores) === 0) {
                if($cambiarTitulo = true) {
                    $newTitulo = $tituloForm;
                }
                else {
                    $newTitulo = $tituloOriginal;
                }
                if ($cambiarSinopsis = true) {
                    $newSinopsis = $sinopsisForm;
                }
                else {
                    $newSinopsis = $sinopsisOriginal;
                }
                if($cambiarGenero = true) {
                    $newGenero = $generoForm;                
                }
                else {
                    $newGenero = $generoOriginal;
                }
                if($cambiarTrailer = true) {
                    $newTrailer = $trailerForm;
                }
                else {
                    $newTrailer = $trailerOriginal;
                }
                $pelicula = Pelicula::editarPeli($idPeli, $newTitulo, $newSinopsis, $newGenero, $file, $newTrailer);            
                move_uploaded_file($file_tmp, $file);
            }
        }
        else {

        }
    }
}  

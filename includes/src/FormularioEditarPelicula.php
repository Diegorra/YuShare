<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Pelicula;

class FormularioEditarPelicula extends Formulario{
    
    private $titulo;

    public function __construct($titulo) {
        $this->titulo = $titulo;
        parent::__construct('formEdit', 
        [
            'formId' => "editMovie",
            'enctype' => "multipart/form-data",
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/perfil.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $idUsuario = $datos['idUsuario'] ?? '';
        $titulo = $datos['titulo'] ?? '';
        $sinopsis = $datos['sinopsis'] ?? '';
        $genero = $datos['genero'] ?? '';
        $src = $datos['src'] ?? '';
        $trailer = $datos['trailer'] ?? '';

        //obtenemos datos de la película
        $pelicula = Pelicula::buscaPelicula($this->titulo);
        
        if($pelicula !== ""){
            $tituloOriginal = $pelicula->getTitulo();
            $sinopsisOriginal = $pelicula->getText();
            $generoOriginal = $pelicula->getGenero();
            $imagenOriginal = $pelicula->getSrc();
            $trailerOriginal = $pelicula->getTrailer();
        }

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'sinopsis','genero', 'file', 'trailer'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos de la película</legend>
            <div>
                <label for="titulo">Titulo: </label>
                <input id="titulo" type="text" name="titulo value="$tituloOriginal" />
                {$erroresCampos['titulo']}
            </div>
            <div>
                <label for="sinopsis">Sinopsis: </label>
                <input id="sinopsis" type="text" name="sinopsis" value="$sinopsisOriginal" />
                {$erroresCampos['sinopsis']}

            </div>
            <div>
                <label for="genero">Género: </label>
                <input id="genero" type="text" name="genero" value="$generoOriginal"/>
                {$erroresCampos['genero']}
            </div>
            <div>
                <input type="file" id="file" name="file" value="$imagenOriginal" />
                {$erroresCampos['file']}
            </div>
            <div>
                <label for="trailer">Trailer: </label>
                <input id="trailer" type="text" name="trailer" value="$trailerOriginal" />
                {$erroresCampos['trailer']}
            </div>
            <div>
                <button type="submit" name="registro">Editar película</button>
            </div>
        </fieldset>
        <script>

        </script>

        EOF;
        return $html;
    }
    
    protected function procesaFormulario(&$datos)
    {
        //obtenemos datos de la película
        $pelicula = Pelicula::buscaPelicula($titulo);

        $idPeli = $pelicula['iduser'];
        $tituloOriginal = $pelicula['titulo'];
        $sinopsisOriginal = $pelicula['text'];
        $generoOriginal = $pelicula['genero'];
        $imagenOriginal = $pelicula['src'];
        $trailerOriginal = $pelicula['trailer'];

        $cambiarTitulo = false;
        $cambiarSinopsis = false;
        $cambiarGenero = false;
        $cambiarImagen = false;
        $cambiarTrailer = false;

        $this->errores = [];

        $tituloForm = trim($datos['titulo'] ?? '');
        $tituloForm = filter_var($tituloForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

         if ($tituloForm !=='') { //Ha cambiado la imagen
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
        //$this->errores['file'] = "Nombre: ".$_FILES['file']['name'];
        
        if(isset($_FILES['file'])){
            $file_ext= strtolower(end(explode('.',$_FILES['file']['name'])));
            $expensions= array("jpeg","jpg","png");
            if(in_array($file_ext,$expensions) === false){
                $this->errores['file'] ="extension not allowed, please choose a JPEG or PNG file.";
            }
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
            $pelicula = Pelicula::editarPeli($idPeli, $titulo, $sinopsis, $genero, $trailer);            
        }
    }
}  

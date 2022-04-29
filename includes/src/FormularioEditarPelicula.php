<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Pelicula;

class FormularioEditarPelicula extends Formulario{
    public function __construct() {
        parent::__construct('formUpload', 
        [
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

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'sinopsis','genero', 'file', 'trailer'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos de la película</legend>
            <div>
                <label for="titulo">Titulo: </label>
                <input id="titulo" type="text" name="titulo" />
                {$erroresCampos['titulo']}
            </div>
            <div>
                <label for="sinopsis">Sinopsis: </label>
                <input id="sinopsis" type="text" name="sinopsis" />
                {$erroresCampos['sinopsis']}

            </div>
            <div>

                <label>Select a Category</label>
                <select name="Category">
                    <?php 
                        $genres=array("Aventuras","Comedia","Drama", "Terror", "Musical","Documental");
                        // use a while loop to fetch data 
                        // from the $all_categories variable 
                        // and individually display as an option
                        foreach($genres as &$x) {
                            echo $genres[$x];
                        }
                    ?>
                </select>
                <label for="genero">Género: </label>
                <input id="genero" type="text" name="genero" />
                {$erroresCampos['genero']}
            </div>
            <div>
                <input type="file" id="file" name="file" />
                {$erroresCampos['file']}
            </div>
            <div>
                <label for="trailer">Trailer: </label>
                <input id="trailer" type="text" name="trailer" />
                {$erroresCampos['trailer']}

            </div>
            <div>
                <button type="submit" name="registro">Subir película</button>
            </div>
        </fieldset>
        <script>

        </script>

        EOF;
        return $html;
    }
    
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
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
    
        $trailer = trim($datos['trailer'] ?? '');
        $trailer = filter_var($trailer, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $trailer || empty($trailer)) {
            $this->errores['trailer'] = 'Introduce un link de un vídeo para el trailer de la película';
        }

        if (count($this->errores) === 0) {
            $pelicula = Pelicula::buscaPelicula($titulo);
            if ($pelicula) {
                $this->errores[] = "La película ya existe";
            } else {
                $pelicula = Pelicula::crea(Aplicacion::getInstance()->idUsuario(), $titulo, $sinopsis, $genero, $file, $trailer);
                move_uploaded_file($file_tmp, $file);
            }
        }
    }  
}
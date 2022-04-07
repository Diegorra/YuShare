<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Pelicula
{
    use MagicProperties;

    private $id;
    private $idUsuario;
    private $titulo;
    private $text;
    private $genero;
    private $src;
    private $numLikes;
    private $trailer;
    
    /**
     * Constructor
    */
    private function __construct($id, $idUsuario, $titulo, $text, $genero, $src, $numLikes, $trailer)
    {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->titulo = $titulo;
        $this->text = $text;
        $this->genero = $genero;
        $this->src = $src;
        $this->numLikes = $numLikes;
        $this->trailer = $trailer;
    }

     public function getTitulo()
    {
        return $this->titulo;
    }

    public function getId()
    {
        return $this->id;
    }

     public function getSrc()
    {
        return $this->src;
    }

     public function getGenero()
    {
        return $this->genero;
    }

     public function getTrailer()
    {
        return $this->trailer;
    }

     public function getNumLikes()
    {
        return $this->numLikes;
    }


     public function getText()
    {
        return $this->text;
    }

    /**
     * Devuelve todas las películas cuyo título contiene $nombrePelicula
    */

    public static function buscaPeliculas($nombrePelicula)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula P WHERE P.titulo LIKE '%%%s%%'", $conn->real_escape_string($nombrePelicula));
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Pelicula($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['src'], $fila['numerototalLikes'], $fila['trailer']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //subir pelicula
    //variable estatica

    public static function subirPelicula($idUsuario, $titulo, $text, $genero, $src, $trailer)
    {
        static $contador = 12;
        $contador = $contador + 1;
        $peli = new Pelicula($contador, $idUsuario, $titulo, $text, $genero, $src, 0, $trailer);
                $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "INSERT INTO pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer) VALUES ($peli->id, $peli->idUsuario, '$peli->titulo', '$peli->text', '$peli->genero', '$peli->src', 0, '$peli->trailer')";
        if ($conn->query($sql) === TRUE) {
              echo "Se ha añadido correctamente la película";
        } else {
              error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    }

    //obtiene pelicula a través de id para mostrar toda la info sobre ella

   public static function todaInfoPeliculas($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT titulo, text, genero, src, numerototalLikes, trailer FROM Pelicula WHERE id = $id");
        
        $result = $conn->query($query);
        if ($result->num_rows > 0){
            $reg = $result->fetch_assoc();
            $contenidoPrincipal = <<<EOF
                <br>
                <br>
                <br>
                <div class ="pelicula">
                    <h1>{$reg['titulo']}</h1>
                    <h2><small>Género: {$reg['genero']}</small></h2>
                    <h2><small>Sinopsis: {$reg['text']}</small></h2>
                    <h2><small>Likes: {$reg['numerototalLikes']}</small></h2>
                    <p><img src="{$reg['src']}"id="image_info"></p>
                    <p><iframe width="560" height="315" src="{$reg['trailer']}" frameborder="0" allowfullscreen></iframe></p>
                </div>
            EOF;
            print $contenidoPrincipal;
            $result->free();
            
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    }

   public static function conseguirPeliculas(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT titulo, src FROM Pelicula");
        $contenido = "";
        if ($result = $conn->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $field1name = $row["titulo"];
                $field3name = $row["src"];
<<<<<<< HEAD
                $htmlPeli =<<<EOS
=======
                $contenido =<<<EOF
                    <br>
                    <br>
>>>>>>> 9aebdd0e688edd58638ad88abc033b0f664da0d5
                    <br>
                    <tr>
                    <td> <img src="{$field3name}" id="image_inicio" ></td>
                    </div>
                    </tr>
<<<<<<< HEAD
                EOS;
                $contenido .= $htmlPeli;
=======
                EOF;
                print $contenido;
>>>>>>> 9aebdd0e688edd58638ad88abc033b0f664da0d5
            }
            $result->free();
            
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $contenido;
    }
}
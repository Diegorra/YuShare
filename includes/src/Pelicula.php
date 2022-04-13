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

    //Getters y Setters
    //-------------------------------------------------------------------------------------------------------
    public function getTitulo()
    {
        return $this->titulo;
    }

    
    //-------------------------------------------------------------------------------------------------------

    
    public static function crea($idUsuario, $titulo, $text, $genero, $src, $trailer)
    {
        $peli = new Pelicula(null, $idUsuario, $titulo, $text, $genero, $src, 0, $trailer);
        return $peli->guarda();
    }
    
    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
        
    private static function inserta($pelicula)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Pelicula (iduser, titulo, text, genero, src, numerototalLikes, trailer) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($pelicula->idUsuario)
            , $conn->real_escape_string($pelicula->titulo)
            , $conn->real_escape_string($pelicula->text)
            , $conn->real_escape_string($pelicula->genero)
            , $conn->real_escape_string($pelicula->src)
            , $conn->real_escape_string($pelicula->numLikes)
            , $conn->real_escape_string($pelicula->trailer)
        );
        if ( $conn->query($query) ) {
            $pelicula->id = $conn->insert_id;
            $result = $pelicula;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function actualiza($pelicula)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Pelicula P SET titulo= '%s', genero='%s', numerototalLikes='%s' WHERE P.id=%d"
            , $conn->real_escape_string($pelicula->titulo)
            , $conn->real_escape_string($pelicula->genero)
            , $conn->real_escape_string($pelicula->numerototalLikes)
            , $pelicula->id
        );

        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            $result = $pelicula;
        }
        
        return $result;
    }
    
    private static function borra($pelicula)
    {
        return self::borraPorId($pelicula->id);
    }
    
    private static function borraPorId($idPelicula)
    {
        if (!$idPelicula) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Pelicula P WHERE P.id = %d"
            , $idPelicula
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    
    //-------------------------------------------------------------------------------------------------------


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

    
    public static function buscaPelicula($nombrePelicula)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula P WHERE P.titulo='%s'", $conn->real_escape_string($nombrePelicula));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Pelicula($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['src'], $fila['numerototalLikes'], $fila['trailer']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    //para mostrar en el perfil las películas asociadas a un usuario
    public static function peliculasPerfil($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula P WHERE P.iduser=$idUsuario");
        $contenido = "";
        $rs = $conn->query($query);
        $result = [];
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[]=new Pelicula($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['src'], $fila['numerototalLikes'], $fila['trailer']);
                $src=$fila['src'];
                $titulo=$fila['titulo'];
                $cont = <<<EOS
                <div class="indexPeliculas"></div> 
                <img src="{$src}" id="image_inicio">
                EOS;
                $contenido .=$cont;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $contenido;
        
    }
    
    //obtiene pelicula a través del id para mostrar toda la información

    public static function todaInfoPeliculas($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT titulo, text, genero, src, numerototalLikes, trailer FROM Pelicula WHERE id = $id");
        
        $result = $conn->query($query);
        if ($result->num_rows > 0){
            $reg = $result->fetch_assoc();
            $contenido = <<<EOF
                <div class ="pelicula">
                    <h1>{$reg['titulo']}</h1>
                    <h2><small>Género: {$reg['genero']}</small></h2>
                    <h2><small>Sinopsis: {$reg['text']}</small></h2>
                    <h2><small>Likes: {$reg['numerototalLikes']}</small></h2>
                    <p><img src="{$reg['src']}"id="image_info"></p>
                    <p><iframe width="560" height="315" src="{$reg['trailer']}" frameborder="0" allowfullscreen></iframe></p>
                </div>
            EOF;
            $result->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $contenido;
    }


   public static function conseguirPeliculas(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT id, src FROM Pelicula");
        $contenido = "";
        if ($result = $conn->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $cartel = $row["src"];
                $htmlPeli =<<<EOS
                    <div class="indexPeliculas"></div> 
                    <img src="{$cartel}" id="image_inicio">
                EOS;
                $contenido .= $htmlPeli;
            }
            $result->free();
            
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $contenido;
    }
}

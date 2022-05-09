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
    private $trailer;
    
    /**
     * Constructor
    */
    private function __construct($id, $idUsuario, $titulo, $text, $genero, $src, $trailer)
    {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->titulo = $titulo;
        $this->text = $text;
        $this->genero = $genero;
        $this->src = $src;
        $this->trailer = $trailer;
    }

    //Getters y Setters
    //-------------------------------------------------------------------------------------------------------
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getIdUser()
    {
        return $this->idUsuario;
    }
    
    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function getSrc()
    {
        return $this->src;
    }

    public function getTrailer()
    {
        return $this->trailer;
    }

    
    //-------------------------------------------------------------------------------------------------------

    
    public static function crea($idUsuario, $titulo, $text, $genero, $src, $trailer)
    {
        $peli = new Pelicula(null, $idUsuario, $titulo, $text, $genero, $src, $trailer);
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
        $query=sprintf("INSERT INTO Pelicula (iduser, titulo, text, genero, src, trailer) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($pelicula->idUsuario)
            , $conn->real_escape_string($pelicula->titulo)
            , $conn->real_escape_string($pelicula->text)
            , $conn->real_escape_string($pelicula->genero)
            , $conn->real_escape_string($pelicula->src)
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
        $query=sprintf("UPDATE Pelicula P SET titulo= '%s', genero='%s' WHERE P.id=%d"
            , $conn->real_escape_string($pelicula->titulo)
            , $conn->real_escape_string($pelicula->genero)
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
        $query = sprintf("DELETE FROM `Pelicula` WHERE `Pelicula`.`id` = $idPelicula;");
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function mostrarComentarios($id)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM 'comentario' WHERE 'idpubli = %s'", $id);
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Comentario($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['src'], $fila['trailer']);  
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    
    //-------------------------------------------------------------------------------------------------------


    /**
     * Devuelve todas las películas cuyo título contiene $nombrePelicula
    */

    public static function buscaPeliculas($nombrePelicula)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula P WHERE P.titulo LIKE '%%%s%%'", $conn->real_escape_string($nombrePelicula));
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Pelicula($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['src'], $fila['trailer']);  
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
        $result = $conn->query($query);
        $peli=null;
        if ($result->num_rows > 0) {
            $reg = $result->fetch_assoc();
            $peli = new Pelicula($reg['id'], $reg['iduser'], $reg['titulo'], $reg['text'], $reg['genero'], $reg['src'], $reg['trailer']);
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        $result->free();
        return $peli;
    }
    
    //para mostrar en el perfil las películas asociadas a un usuario
    public static function peliculasPerfil($idUsuario)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula P WHERE P.iduser='%s'", $conn->real_escape_string($idUsuario));
        $contenido = "";
        $rs = $conn->query($query);
        $result = [];
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[]=new Pelicula($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['src'], $fila['trailer']);
                $src=$fila['src'];
                $titulo=$fila['titulo'];
                $id = $fila['id'];
                $peliculaUrl = $app->buildUrl('/peliIndv.php', ['id'=> $id]);
                $cont = <<<EOS
                <div class="indexPeliculas">
                    <a href="{$peliculaUrl}">
                        <img src="{$src}" id="image_inicio" alt="img_perfil">
                    </a>
                </div> 
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
    public static function todaInfoPeliculas($id){ 
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula WHERE id = '%s'", $conn->real_escape_string($id));
        $result = $conn->query($query);
        $peli = "";
        if ($result->num_rows > 0) {
            $reg = $result->fetch_assoc();
            $peli = new Pelicula($reg['id'], $reg['iduser'], $reg['titulo'], $reg['text'], $reg['genero'], $reg['src'], $reg['trailer']);
        } 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        $result->free();
        return $peli;
    }

    public static function borrarPeli($idPeli, $idU) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT idUser, id FROM Pelicula WHERE idUser = '%s' AND id = '%s'",$conn->real_escape_string($idU), $conn->real_escape_string($idPeli));
        if($result = $conn->query($query)) {
            $borrar = self::borraPorId($idPeli);
        }
    }

    public static function editarPeli($id, $titulo, $sinopsis, $genero, $src, $trailer) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Pelicula P SET titulo= '%s', text='%s',genero='%s', src='%s', trailer='%s' WHERE P.id=%d"
            , $conn->real_escape_string($titulo)
            , $conn->real_escape_string($sinopsis)
            , $conn->real_escape_string($genero)
            , $conn->real_escape_string($src)
            , $conn->real_escape_string($trailer)
            , $id
        );
        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            $result = true;
        }
        return $result;
    }

    public static function conseguirPeliculas(){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula");
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Pelicula($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['src'], $fila['trailer']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
}

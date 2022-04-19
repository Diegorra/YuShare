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

    public function getNumLikes()
    {
        return $this->numLikes;
    }

    public function getTraile()
    {
        return $this->trailer;
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
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula P WHERE P.titulo LIKE '%%%s%%'", $conn->real_escape_string($nombrePelicula));
        $rs = $conn->query($query);
        $result = [];
        $contenido = "";
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                //$result[] = new Pelicula($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['src'], $fila['numerototalLikes'], $fila['trailer']);
                $titulo=$fila['titulo'];
                $src=$fila['src'];
                $peliculaUrl = $app->buildUrl('/peliIndv.php', ['id'=> $fila['id']]);
                $peli = <<<EOS
                    <div class="search">
                        <a href="{$peliculaUrl}">
                            <img src="{$src}" id="image_inicio" alt="img_search">
                            <h1>{$titulo}</h1>
                        </a>
                    </div> 
                    <p></p>
                EOS;
                $contenido .=$peli;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $contenido;
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
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula P WHERE P.iduser='%s'", $conn->real_escape_string($idUsuario));
        $contenido = "";
        $rs = $conn->query($query);
        $result = [];
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[]=new Pelicula($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['src'], $fila['numerototalLikes'], $fila['trailer']);
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
        $query = sprintf("SELECT id, iduser, titulo, text, genero, src, numerototalLikes, trailer FROM Pelicula WHERE id = '%s'", $conn->real_escape_string($id));
        $contenido = "";
        $result = $conn->query($query);
        if ($result->num_rows > 0){
            $reg = $result->fetch_assoc();
            $contenido = <<<EOF
                <div class ="pelicula">
                    <h1>{$reg['titulo']}</h1>
                    <h2><small>Género: {$reg['genero']}</small></h2>
                    <h2><small>Sinopsis: {$reg['text']}</small></h2>
                    <h2><small>Likes: {$reg['numerototalLikes']}</small></h2>
                    <p><img src="{$reg['src']}"id="image_info" alt="img_indv"></p>
                    <p><iframe width="560" height="315" src="{$reg['trailer']}" frameborder="0" allowfullscreen></iframe></p>
                </div>
            EOF;
            /*
            $borra = "";
            if($app->idUsuario() == $reg['iduser']) {
                $borrarPeliUrl = $app->buildUrl('/deleteMovie.php', ['id'=> $reg['id'], 'idUser' => $reg['iduser']]);
                $borrar = <<<EOS
                    <div class ="botonBorrar">
                        <a href="{$borrarPeliUrl}">Delete</a>
                    </div>
                EOS;
                $contenido .= $borrar;
             }
            $result->free();*/
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $contenido;
    }

    public static function borrarPeli($idU, $idPeli) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT idUser, id FROM Pelicula WHERE idUser = '%s' AND id = '%s'",$conn->real_escape_string($idU), $conn->real_escape_string($idPeli));
        if($result = $conn->query($query)) {
            $borrar = self::borraPorId($idPeli);
        }
    }

    public static function conseguirPeliculas(){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT id, src FROM Pelicula");
        $contenido = "";
        if ($result = $conn->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $cartel = $row["src"];
                $peliculaUrl = $app->buildUrl('/peliIndv.php', ['id'=> $id]);
                $htmlPeli =<<<EOS
                    <div class="indexPeliculas">
                        <a href="{$peliculaUrl}">
                            <img src="{$cartel}" id="image_inicio" alt="img_index">
                        </a>
                    </div> 
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

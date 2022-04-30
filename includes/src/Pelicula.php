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

    public function getTrailer()
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
        $query = sprintf("DELETE FROM `Pelicula` WHERE `Pelicula`.`id` = $idPelicula;");
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private static function editarPorId($idPelicula) {
        if (!$idPelicula) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE FROM `Pelicula` WHERE `Pelicula`.`id` = $idPelicula;");
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
        $query = sprintf("SELECT id, iduser, titulo, text, genero, src, trailer FROM Pelicula WHERE id = '%s'", $conn->real_escape_string($id));
        $contenido = "";
        $result = $conn->query($query);
        if ($result->num_rows > 0){
            $reg = $result->fetch_assoc();
            $contenido = <<<EOF
                <table border="1" width="100%">
                    <tr>
                        <th width="30%">Genero</th>
                        <th width="32%">Sinopsis</th>
                        <th width="47%"></th>
                        <th width="40%"></th>
                    </tr>
                    <div class ="pelicula">
                        <h1>{$reg['titulo']}</h1>
                    </div>
                    <td><h2><small>{$reg['genero']}</small></h2></td>
                    <td><h2><small>{$reg['text']}</small></h2></td>
                    <td><p><img src="{$reg['src']}"id="image_info" alt="img_indv"></p></td>
                    <td><p><iframe width="560" height="315" src="{$reg['trailer']}" frameborder="0" allowfullscreen></iframe></p></td>
                </table>
            EOF;
            $editar = "";
            if($app->idUsuario() == $reg['iduser']) {
                $editar = <<<EOS
                    <div class ="botonEditaryBorrar">
                        <button id="editFilm" type="button" filmId="{$reg['id']}" userID="{$reg['iduser']}">Editar</button>
                    </div>
                EOS;
                $contenido .= $editar;
            }
            $borra = "";
            if($app->idUsuario() === $reg['iduser']  || $app->esAdmin()) {
                $borrar = <<<EOS
                    <div class ="botonEditaryBorrar">
                        <button id="deleteFilm" type="button" filmId="{$reg['id']}">Borrar</button>
                    </div>
                EOS;
                $contenido .= $borrar;
            }
            $result->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $contenido;
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
        $query=sprintf("UPDATE Pelicula P SET titulo= '%s', text='%s',genero='%s', trailer='%s' WHERE P.id=%d"
            , $conn->real_escape_string($titulo)
            , $conn->real_escape_string($sinopsis)
            , $conn->real_escape_string($genero)
            , $conn->real_escape_string($trailer)
            , $id
        );

        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            $result = $pelicula;
        }
        return $result;
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

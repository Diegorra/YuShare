<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Amigos
{
    use MagicProperties;

    private $idAmigo;
    private $idUsuario;
    private $nombreAmigo;
    private $agregado;
    
    /**
     * Constructor
    */
    private function __construct($id, $nombreAmigo,$idUsuario, $agregado)
    {
        $this->idAmigo = $id;
        $this->nombreAmigo = $nombreAmigo;
        $this->idUsuario = $idUsuario;
        $this->agregado = $agregado;
    }

    //Getters y Setters
    //-------------------------------------------------------------------------------------------------------
    
    public function getIdAmigo()
    {
        return $this->idAmigo;
    }

     public function getnombreAmigo()
    {
        return $this->nombreAmigo;
    }
    
    public function getIdUser()
    {
        return $this->idUsuario;
    }
    
    public function getAgregado()
    {
        return $this->agregado;
    }
    
    //-------------------------------------------------------------------------------------------------------

    public static function agrega($idAmigo, $nombreAmigo, $idUsuario)
    {
        $amigo = new Amigo($idAmigo, $nombreAmigo, $idUsuario, true);
        return $amigo->guarda();
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
        
    private static function inserta($amigo)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Amigo (idAmigo, nombreAmigo, idUsuario, agregado) VALUES ('%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($amigo->idAmigo)
            , $conn->real_escape_string($amigo->nombreAmigo)
            , $conn->real_escape_string($amigo->idUsuario)
            , $amigo->agregado
        );
        if ( $conn->query($query) ) {
            $result = $amigo;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function actualiza($amigo)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Amigo A SET idAmigo= '%s', nombreAmigo='%s', idUsuario='%s', agregado='%s',  WHERE A.id=%d"
            , $conn->real_escape_string($amigo->idAmigo)
            , $conn->real_escape_string($amigo->nombreAmigo)
            , $conn->real_escape_string($amigo->idUsuario)
            , $amigo->idAmigo 
        );
        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            $result = $pelicula;
        }
        return $result;
    }
    
    private static function borra($amigo)
    {
        return self::borraPorId($amigo->idAmigo, $amigo->idUser);
    }
    
    private static function borraPorId($idAmigo, $idUser)
    {
        if (!$idAmigo) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM 'Amigo' WHERE 'Amigo'.'idAmigo' = $idAmigo AND 'Amigo'.'idUser = $idUser;");
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private static function unfriend($idAmigo, $idUsuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Amigo A SET agregado= 0 WHERE A.idAmigo=$idAmigo AND A.iduser = $idUser");
        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        } else {
            return true;
        }
    }
    
    //-------------------------------------------------------------------------------------------------------

    //Devuelve la lista de amigos del usuario
    public static function listaAmigos($idUsuario) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM Amigo A WHERE A.iduser = $idUsuario AND A.agregado=1");
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Amigos($fila['idamigo'], $fila['iduser'], $fila['agregado']);  
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //busca los amigos del usuario segun el nombre (idk si hace falta lol)
    public static function buscaAmigos($nombreAmigos)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM Amigos A WHERE A.nombreAmigo LIKE '%%%s%%'", $conn->real_escape_string($nombreAmigos));
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Amigos($fila['idAmigo'], $fila['idUser'], $fila['agregado']);  
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //borra un amigo
    public static function borrarAmigo($idAmigo, $idUsuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT idAmigo, idUser FROM Amigo WHERE idAmigo = '%s' AND idUser = '%s'",
            $conn->real_escape_string($idAmigo), $conn->real_escape_string($idUsuario));
        if($result = $conn->query($query)) {
            $unfriend = self::unfriend($idAmigo, $idUsuario);
        }
    }
}

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
    private $estado;
    
    /**
     * Constructor
    */
    private function __construct($id, $idUsuario, $nombreAmigo, $estado)
    {
        $this->idAmigo = $id;
        $this->nombreAmigo = $nombreAmigo;
        $this->idUsuario = $idUsuario;
        $this->estado = $estado;
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
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    //-------------------------------------------------------------------------------------------------------

    public static function agrega($idAmigo, $nombreAmigo, $idUsuario)
    {
        $amigo = new Amigos($idAmigo, $nombreAmigo, $idUsuario, true);
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
        $query=sprintf("INSERT INTO Amigo (idAmigo, nombreAmigo, idUsuario, estado) VALUES ('%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($amigo->idAmigo)
            , $conn->real_escape_string($amigo->nombreAmigo)
            , $conn->real_escape_string($amigo->idUsuario)
            , $conn->real_escape_string($amigo->estado)
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
        $query=sprintf("UPDATE Amigo A SET idAmigo= '%s', nombreAmigo='%s', idUsuario='%s', estado='%s',  WHERE A.id=%d"
            , $conn->real_escape_string($amigo->idAmigo)
            , $conn->real_escape_string($amigo->nombreAmigo)
            , $conn->real_escape_string($amigo->idUsuario)
            , $conn->real_escape_string($amigo->estado)
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
        $query = sprintf("DELETE FROM amigo A WHERE A.idAmigo = $idAmigo AND A.idUsuario = $idUser");
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    //-------------------------------------------------------------------------------------------------------

    //Devuelve la lista de amigos del usuario
    public static function listaAmigos($idUsuario) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT idAmigo, idUsuario, nombreAmigo, estado FROM Amigo A WHERE A.idUsuario = $idUsuario 
				AND A.estado='Agregado'");
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Amigos($fila['idAmigo'], $fila['idUsuario'],$fila['nombreAmigo'], $fila['estado']);  
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //Saca a todos los usuarios no agregados
    public static function obtenerUsuarios($idUsuario)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT idAmigo, idUsuario, nombreAmigo, estado FROM Amigo A WHERE A.idUsuario ='%s' AND A.estado ='No'", 
            $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Amigos($fila['idAmigo'], $fila['idUsuario'], $fila['nombreAmigo'], $fila['estado']);  
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
        $query=sprintf("UPDATE amigo A SET A.estado = 'No' WHERE idUsuario = '%s' AND idAmigo = '%s'",
    		$conn->real_escape_string($idUsuario), 
            $conn->real_escape_string($idAmigo)
        );
        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        } else {
            return true;
        }
    }

    //agrega un amigo
    public static function agregarAmigo($idAmigo, $idUsuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE amigo A SET A.estado = 'Agregado' WHERE idUsuario = '%s' AND idAmigo = '%s'",
            $conn->real_escape_string($idUsuario), 
            $conn->real_escape_string($idAmigo)
        );
        $returnear = returnearAmigo($idUsuario, $idAmigo);
        if (!$conn->query($query) || !$returnear ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        } else {
            return true;
        }
    }

    //Amistad automatica
    public static function returnearAmigo($idAmigo, $idUsuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE amigo A SET A.estado = 'Agregado' WHERE idUsuario = '%s' AND idAmigo = '%s'",
            $conn->real_escape_string($idUsuario), 
            $conn->real_escape_string($idAmigo)
        );
        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        } else {
            return true;
        }
    }

    public static function esAmigo($idAmigo, $idUsuario) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT idAmigo, idUsuario, nombreAmigo, estado FROM Amigo A WHERE A.idUsuario ='%s' AND A.idAmigo='%s' AND A.estado ='Agregado'"
            , $conn->real_escape_string($idUsuario)
            , $conn->real_escape_string($idAmigo)

        );
        $result = $conn->query($query);
        $solucion = true;
        if($result->num_rows > 0) {
             return $solucion;
        }
        else if($result->num_rows == 0){
            $solucion = false;
            return $solucion;
        } 
        else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

}

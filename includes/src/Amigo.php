<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\MagicProperties;

class Amigo
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
    /**
     * Crea una solicitud de amistad DESDE PERFIL
     */
    public static function peticionAmistad($idAmigo, $idUsuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Amigo(idAmigo, idUsuario, nombreAmigo, estado) VALUES ('%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($idAmigo)
            , $conn->real_escape_string($idUsuario)
            , Usuario::buscaPorId($idAmigo)->getNombreUsuario()
            , 'Pendiente'
        );
        $result = false;
        if ( $conn->query($query) ) {
            $result = true;
            self::amistadInversa($idUsuario, $idAmigo);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    /**
     * Cuando el usuario decide aceptar la solicitud de amistad del usuario con idAmigo DESDE LA LISTA DE AMIGOS
     */
    public static function agregarAmigo($idAmigo, $idUsuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Amigo A SET A.estado = 'Agregado' WHERE idUsuario = '%s' AND idAmigo = '%s'",
            $conn->real_escape_string($idUsuario), 
            $conn->real_escape_string($idAmigo)
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        } else {
            self::aceptacionMutua($idAmigo, $idUsuario);
            return true;
        }
    }

   public static function amistadInversa($id1, $id2) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Amigo(idAmigo, idUsuario, nombreAmigo, estado) VALUES ('%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($id1)
            , $conn->real_escape_string($id2)
            , Usuario::buscaPorId($id1)->getNombreUsuario()
            , 'Pendiente'
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        } else {
            return true;
        }
    }


   public static function aceptacionMutua($id1, $id2) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Amigo A SET A.estado = 'Agregado' WHERE idUsuario = '%s' AND idAmigo = '%s'",
            $conn->real_escape_string($id1), 
            $conn->real_escape_string($id2)
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        } else {
            return true;
        }

    }

    /**
     * Elimina al amigo con idAmigo
     */
    public static function borraAmigo($idAmigo, $idUser)
    {
        if (!$idAmigo) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM `Amigo`  WHERE `Amigo`.`idAmigo` = $idAmigo AND `Amigo`.`idUsuario` = $idUser;");
        if ( ! $conn->query($query) || ! $conn->query($query2)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    //-------------------------------------------------------------------------------------------------------

    /**
     * Devuelve la lista de amigos del usuario con idUsuario
     */
    public static function listaAmigos($idUsuario) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT idAmigo, idUsuario, nombreAmigo, estado FROM Amigo A WHERE A.idUsuario = '%s' AND A.estado='Agregado'", 
            $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Amigo($fila['idAmigo'], $fila['idUsuario'],$fila['nombreAmigo'], $fila['estado']);  
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    /**
     * Devuelve la lista de solicitudes de amistad para el usuario con idUsuario
     */
    public static function obtenerUsuarios($idUsuario)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT idAmigo, idUsuario, nombreAmigo, estado FROM Amigo A WHERE A.idUsuario ='%s' AND A.estado ='Pendiente'", 
            $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Amigo($fila['idAmigo'], $fila['idUsuario'], $fila['nombreAmigo'], $fila['estado']);  
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    /**
     * Devuelve si el usuario con idAmigo es amigo de idUsuario
     */
    public static function esAmigo($idAmigo, $idUsuario) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT idAmigo, idUsuario, nombreAmigo, estado FROM Amigo A WHERE A.idUsuario ='%s' AND A.idAmigo='%s' AND A.estado ='Agregado'"
            , $conn->real_escape_string($idUsuario)
            , $conn->real_escape_string($idAmigo)

        );
        
        $result = $conn->query($query);
        $solucion = true;
        
        if($result->num_rows == 0){
            $solucion = false;
        }
        
        if (!$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        } 
        return $solucion;
    }

}

<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\MagicProperties;

class Comentario
{
    use MagicProperties;

    private $id;
    private $idPeli;
    private $idUsuario;
    private $text;
    
    /**
     * Constructor
    */
    private function __construct($id, $idPeli, $idUsuario, $text)
    {
        $this->id = $id;
        $this->idPeli = $idPeli;
        $this->idUsuario = $idUsuario;
        $this->text = $text;
    }

    //Getters y Setters
    //-------------------------------------------------------------------------------------------------------
    
    public function getId()
    {
        return $this->id;
    }

     public function getIdPeli()
    {
        return $this->idPeli;
    }
    
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    
    public function getText()
    {
        return $this->text;
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



}

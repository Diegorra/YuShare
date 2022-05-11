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

    public static function mostrarComentarios($idPeli)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM comentario WHERE idpubli = %s ORDER BY `comentario`.`id` DESC", $idPeli);
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Comentario($fila['id'], $fila['idpubli'], $fila['iduser'], $fila['text']);  
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function insertComentario($coment_text,$idPeli,$idUsuario){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("INSERT INTO comentario (id, idpubli, iduser, text) VALUES ('%s', '%s', '%s', '%s')"
            , $conn->insert_id
            , $conn->real_escape_string($idPeli)
            , $conn->real_escape_string($idUsuario)
            , $conn->real_escape_string($coment_text)
        );
        $rs = $conn->query($query);
    }

    public static function borrarComentario($id){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("DELETE FROM comentario WHERE id = %s", $id);
        $rs = $conn->query($query);
    }


}

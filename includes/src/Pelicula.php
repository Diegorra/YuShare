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
    private $año;
    private $src;
    private $numLikes;
    private $trailer;
    
    /**
     * Constructor
    */
    private function __construct($id, $idUsuario, $titulo, $text, $genero, $año, $src, $numLikes, $trailer)
    {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->titulo = $titulo;
        $this->text = $text;
        $this->genero = $genero;
        $this->año = $año;
        $this->src = $src;
        $this->numLikes = $numLikes;
        $this->trailer = $trailer;
    }

     public function getTitulo()
    {
        return $this->titulo;
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
                $result[] = new Pelicula($fila['id'], $fila['iduser'], $fila['titulo'], $fila['text'], $fila['genero'], $fila['año'], $fila['src'], $fila['numerototalLikes'], $fila['trailer']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //subir pelicula

    public static function subirPelicula($idUsuario, $titulo, $text, $genero, $src, $trailer)
    {
        $year = date("Y-m-d");
        static $contador = 13;
        $peli = new Pelicula($contador, $idUsuario, $titulo, $text, $genero, $year, $src, 0, $trailer);
        $contador++;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "INSERT INTO pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer) VALUES ($peli->id, $peli->idUsuario, '$peli->titulo', '$peli->text', '$peli->genero', $peli->año, '$peli->src', 0, '$peli->trailer')";
        if ($conn->query($sql) === TRUE) {
              echo "Se ha añadido correctamente la película";
        } else {
              error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

    }

    //obtiene pelicula para mostrarla

   public static function conseguirPeliculas()
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT titulo, text, genero, año, src, numerototalLikes, trailer FROM Pelicula");
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            $result = $rs->fetch_all();
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
}
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
    private $contador = 13;

    /**
     * Devuelve todas las películas cuyo título contiene $nombrePelicula
    */
    public static function buscaPeliculas($nombrePelicula)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Pelicula P WHERE P.titulo LIKE '%s'", $conn->real_escape_string($nombrePelicula));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = $rs->fetch_all();
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //subir pelicula

    private function create($idUsuario, $titulo, $text, $genero, $src, $trailer)
    {
        $this->id = $contador;
        $contador++;
        $this->idUsuario = $idUsuario;
        $this->titulo = $titulo;
        $this->text = $text;
        $this->genero = $genero;
        $this->src = $src;
        $this->trailer = $trailer;
        $this->año = date("Y-m-d");
        $this->numLikes = 0;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "INSERT INTO pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer) VALUES ($this->id, $this->idUsuario, $this->titulo, $this->text, $this->genero, $this->año, $this->src, $this->numLikes, $this->trailer)";
        if (mysqli_query($conn, $sql)) {
              echo "Se ha añadido correctamente la película";
        } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }

   public static function conseguirPeliculas()
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT titulo, text, genero, año, src, numerototalLikes, trailer FROM Pelicula");
        $rs = $conn->query($query);
        if ($rs) {
            $result = $rs->fetch_all();
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
}
<?php
require_once __DIR__.'/Aplication.php';

class Usuario
{
    private $id;

    private $name;

    private $password;

    private $role;

    private function __construct($name, $password, $role)
    {
        $this->name= $name;
        $this->password = $password;
        $this->role = $role;
    }

    public static function login($name, $password)
    {
        $usuario = self::buscaUsuario($name);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }

    public static function buscaUsuario($name)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.name = '%s'", $conn->real_escape_string($name));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['name'], $fila['password'], $fila['role']);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function crea($name, $password, $role)
    {
        $user = self::buscaUsuario($name);
        if ($user) {
            return false;
        }
        $user = new Usuario($name, self::hashPassword($password), $role);
        return self::guarda($user);
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function guarda($usuario)
    {
        if ($usuario->id !== null) {
            return self::actualiza($usuario);
        }
        return self::inserta($usuario);
    }

    private static function inserta($usuario)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO usuario(name, password, role) VALUES('%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->name)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->role));
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
    
    private static function actualiza($usuario)
    {
        $result = false;
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE usuario U SET name = '%s', password='%s', role='%s' WHERE U.id=%i"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->role)
            , $usuario->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->id;
            }
            else{
                $result = $usuario;
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        }
        
        return $result;
    }
   
    private static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }
    
    private static function borraPorId($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 

        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM usuario U WHERE U.id = %d", $idUsuario);
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getrole()
    {
        return $this->role;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}
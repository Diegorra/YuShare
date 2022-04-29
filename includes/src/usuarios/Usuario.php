<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Usuario
{
    use MagicProperties;

    public const ADMIN_ROLE = 1;

    public const USER_ROLE = 2;

    public static function login($nombreUsuario, $password)
    {
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }
    
    public static function crea($nombreUsuario, $password, $email)
    {
        $user = new Usuario(null, $nombreUsuario, self::hashPassword($password), $email, "images/defaultProfile.jpg", self::USER_ROLE);
        return $user->guarda();
    }

    /**
     * Devuelve todos los usuarios cuyo nombre de usuario contiene $nombreUsuario
     */
    public static function buscaUsuarios($nombreUsuario)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario U WHERE U.userName LIKE '%%%s%%'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Usuario($fila['id'], $fila['userName'], $fila['passwd'], $fila['email'], $fila['image'], $fila['role']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario U WHERE U.userName='%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['id'], $fila['userName'], $fila['passwd'], $fila['email'], $fila['image'], $fila['role']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario WHERE id='%s'", $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['id'], $fila['userName'], $fila['passwd'], $fila['email'], $fila['image'], $fila['role']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorEmail($emailusuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario WHERE email='%s'", $conn->real_escape_string($emailusuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['id'], $fila['userName'], $fila['passwd'], $fila['email'], $fila['image'], $fila['role']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

       
    private static function inserta($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Usuario(userName, passwd, email, image, enabled, role) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->userName)
            , $conn->real_escape_string($usuario->passwd)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->image)
            , 1
            , $conn->real_escape_string($usuario->role)
        );
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
            $result = $usuario;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   

    public static function amigo($usuario) {


        
    }

    
    public static function actualiza($usuario, $nombre, $image, $email, $password)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuario SET userName='%s', passwd='%s', email='%s', image='%s', role='%s' WHERE id=%d"
            , $conn->real_escape_string($nombre)
            , $conn->real_escape_string($password)
            , $conn->real_escape_string($email)
            , $conn->real_escape_string($image)
            , $conn->real_escape_string($usuario->role)
            , $conn->real_escape_string($usuario->id)
        );
        if ( $conn->query($query) ) {
            $result = $usuario;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function actualizaSetting ($usuario, $nombre, $email, $image)
    {
        Usuario::actualiza($usuario, $nombre, $image, $email, $usuario->passwd);
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
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Usuario U WHERE U.id = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $id;

    private $userName;

    private $passwd;

    private $email;

    private $image;

    private $role;

    private function __construct($id, $userName, $passwd, $email, $image, $role)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->passwd = $passwd;
        $this->email = $email;
        $this->image = $image;
        $this->role = $role;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombreUsuario()
    {
        return $this->userName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->passwd);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->passwd = self::hashPassword($nuevoPassword);
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
}

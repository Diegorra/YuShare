<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';

class FormularioRegistro extends Form
{
    
    public function __construct() {
        parent::__construct('RegisterForm');
    }


    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCamposFormulario($datosIniciales)
    {
       $contenidoPrincipal = <<<EOF
            <form action="procesarRegistro.php" method="POST">
            <fieldset>
                <div class="grupo-control">
                    <label>Nombre de usuario:</label> <input class="control" type="text" name="nombreUsuario" />
                </div>
                <div class="grupo-control">
                    <label>Nombre completo:</label> <input class="control" type="text" name="nombre" />
                </div>
                <div class="grupo-control">
                    <label>Password:</label> <input class="control" type="password" name="password" />
                </div>
                <div class="grupo-control"><label>Vuelve a introducir el Password:</label> <input class="control" type="password" name="password2" /><br /></div>
                <div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
            </fieldset>
            </form>
        EOF;

        return $contenidoPrincipal;
    }

    /**
     * Procesa los datos del formulario.
     *
     * @param string[] $datos Datos enviado por el usuario (normalmente <code>$_POST</code>).
     *
     * @return string|string[] Devuelve el resultado del procesamiento del formulario, normalmente una URL a la que
     * se desea que se redirija al usuario, o un array con los errores que ha habido durante el procesamiento del formulario.
     */
    protected function procesaFormulario($datos)
    {
        $erroresFormulario = array();

        $nombreUsuario = $datos['nombreUsuario'] ?? null;
        if ( empty($nombreUsuario) || mb_strlen($nombreUsuario) < 5 ) {
            $erroresFormulario[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }

         $nombre = $datos['nombre'] ?? null;
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $erroresFormulario[] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }

        $password = $datos['password'] ?? null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $password2 = $datos['password2'] ?? null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $erroresFormulario[] = "Los passwords deben coincidir";
        }

        if (count($erroresFormulario) === 0) {
            $user = Usuario::crea($nombreUsuario, $nombre, $password, 'user');	
            if (!$user){
                $erroresFormulario[] = "El usuario ya existe";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombre;
                header('Location: index.php');
                return 'index.php';
            }
        }
        return $erroresFormulario;
    }
  
}
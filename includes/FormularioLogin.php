<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';

class FormularioLogin extends Form{
    
    public function __construct() {
        parent::__construct('LoginForm');
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
            <form action="procesarLogin.php" method="POST">
            <fieldset>
                <legend>Usuario y contraseña</legend>
                <div class="grupo-control">
                    <label>Nombre de usuario:</label> <input type="text" name="nombreUsuario" />
                </div>
                <div class="grupo-control">
                    <label>Password:</label> <input type="password" name="password" />
                </div>
                <div class="grupo-control"><button type="submit" name="login">Entrar</button></div>
            </fieldset>
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
        if ( empty($nombreUsuario) ) {
            $erroresFormulario[] = "El nombre de usuario no puede estar vacío";
        }

        $password = $datos['password'] ?? null;
        if ( empty($password) ) {
            $erroresFormulario[] = "El password no puede estar vacío.";
        }

        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::login ($nombreUsuario, $password);
            if ( !$usuario) {		
                // No se da pistas a un posible atacante
                $erroresFormulario[] = "El usuario o el password no coinciden";
            } 
            else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->getNombre(); //Capturamos el nombre real del usuario
                $_SESSION['esAdmin'] = strcmp($usuario->getRol(), 'admin') == 0 ? true : false;				
                return 'index.php';
            }
        }

        return $erroresFormulario;
    }
  
}
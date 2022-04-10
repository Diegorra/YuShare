<?php

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioSettings extends Formulario{
    
    public function __construct() {
        parent::__construct('formSettings', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        //$nombreUsuario = $datos['nombreUsuario'] ?? '';
        $nombreUsuario = $_SESSION['nombre'] ?? '';
        $emailUsuario = $_SESSION['email'] ?? '';

        //echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'email', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Editar Perfil</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario:</label>
                <input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario"/>
                {$erroresCampos['nombreUsuario']}
            </div>
            <div>
            <label for="email">Email:</label>
            <input id="email" type="text" name="email" value="$emailUsuario"/>
            {$erroresCampos['email']}
        </div>
            <div>
                <label for="password">Nueva contraseña:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
            </div>
            <div>
                <label for="password2">Repetir nueva contraseña:</label>
                <input id="password2" type="password2" name="password2" />
                {$erroresCampos['password2']}
            </div>
            <div>
                <button type="submit" name="edit">Editar perfil</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $nombreUsuario = $_SESSION['nombre'] ?? '';
        $emailUsuario = $_SESSION['email'] ?? '';

        $this->errores = [];
        $cambiarNombre = false;
        $cambiarEmail = false;
        $cambiarPassword = false;

        $nombreUsuarioForm = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuarioForm = filter_var($nombreUsuarioForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($nombreUsuario !== $nombreUsuarioForm && $nombreUsuarioForm !=='') { //Ha cambiado el nombre
            //$this->errores['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
            
            //Se busca si el nombre exitse
            $newNombreUsuarioForm = Usuario::buscaUsuario($nombreUsuarioForm); 
            
            if ($newNombreUsuarioForm) {
                $this->errores[] = "El usuario ya existe (nombre)";
            }
            else{
                $cambiarNombre = true;
            }
        }

        echo '<pre>' . print_r($nombreUsuario, TRUE) . '</pre>';
        echo '<pre>' . print_r($nombreUsuarioForm, TRUE) . '</pre>';

        $emailUsuarioForm = trim($datos['email'] ?? '');
        $emailUsuarioForm = filter_var($emailUsuarioForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!filter_var($emailUsuarioForm, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'El email tiene que ser un email válido.';
        }
        if ($_SESSION['nombre'] !== $emailUsuarioForm) { //Ha cambiado el email
            //$this->errores['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
            
            //Se busca si el nombre exitse
            $emailUsuarioForm = Usuario::buscaUsuario($emailUsuarioForm); 
            
            if ($emailUsuarioForm) {
                $this->errores[] = "El usuario ya existe (email)";
            }
            else{
                $cambiarEmail = true;
            }
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if($password)
        {
            if (mb_strlen($password) < 5 ) {
                $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
            }

            $password2 = trim($datos['password2'] ?? '');
            $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $password2 || $password != $password2 ) {
                $this->errores['password2'] = 'Los passwords deben coincidir';
            }
        }
        else{
            $cambiarPassword = true;
        }
       


        if (count($this->errores) === 0) {

            if($cambiarNombre)
            {
                $newNombre = $nombreUsuarioForm;
            }
            else
            {
                $newNombre = $_SESSION['nombre'];
            }

            if($cambiarEmail)
            {
                $newEmail = $emailUsuarioForm;
            }
            else
            {
                $newEmail = $_SESSION['email'];
            }

            if($cambiarPassword)
            {
                $newPass = $password;
                $newUsuario = Usuario::crea($newNombre, $newPass, $newEmail);

                $newUsuario = Usuario::actualiza($newUsuario);
            }
            else{
                $newUsuario = Usuario::actualizaSetting($newNombre, $newEmail);
            }

   
            

            $usuario = Usuario::actualiza($newUsuario); 
            
            if ($usuario) {
                $app = Aplicacion::getInstance();
                $app->login($usuario);
            }
        }


    }



}
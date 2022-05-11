<?php

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioSettings extends Formulario{
    
    public function __construct() {
        //parent::__construct('formSettings', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
        parent::__construct('formSearch', [
            'formId' => "settings",
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')
        ]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        /*
            CAMBIAR IMAGEN
        */
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        //$nombreUsuario = $datos['nombreUsuario'] ?? '';
        $nombreUsuario = $_SESSION['nombre'] ?? '';
        $emailUsuario = $_SESSION['email'] ?? '';

        //echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'image', 'email', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));

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
                <label for="image">Imagen:</label>
                <input id="image" type="file" name="image"/>
                {$erroresCampos['image']}
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
                <input id="password2" type="password" name="password2" />
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
        $this->errores = [];

        $nombreUsuario = $_SESSION['nombre'] ?? '';
        $emailUsuario = $_SESSION['email'] ?? '';



        $target_dir = "images/";


        $cambiarNombre = false;
        $cambiarEmail = false;
        $cambiarPassword = false;
        $cambiarImagen = false;

        if(isset($_FILES['image']['tmp_name']))
        {
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) 
            {
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check !== false) 
                {
                    $uploadOk = 1;
                } 
                else 
                {
                    $this->errores[] = "El archivo no es una imagen.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) 
            {
                $this->errores['image'] = "El archivo ya existe.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["image"]["size"] > 500000) 
            {
                $this->errores['image'] = "El archivo es demasiado grande.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
            {
                $this->errores['image'] = "Solo se permiten archivos JPG, JPEG, PNG & GIF.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $this->errores['image'] = "El archivo no se ha podido subir.";
                // if everything is ok, try to upload file
            } 
            else 
            {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo("El archivo ". basename( $_FILES["image"]["tmp_name"]). " ha sido subido.");
                    $cambiarImagen = true;
                } 
                else 
                {
                    $this->errores['image'] = "Ha habido un error al subir el archivo.";
                }
            }




        }

        $nombreUsuarioForm = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuarioForm = filter_var($nombreUsuarioForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($nombreUsuarioForm !=='') { //Ha cambiado el nombre
            //$this->errores['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
            
            //Se busca si el nombre exitse
            $newNombreUsuarioForm = Usuario::buscaUsuario($nombreUsuarioForm); 
            
            if ($newNombreUsuarioForm && $nombreUsuario !== $nombreUsuarioForm) {
                $this->errores[] = "El usuario ya existe (nombre)";
            }
            else{
                $cambiarNombre = true;
            }
        }


        
        /*$imageUsuarioForm = trim($datos['image'] ?? '');
        $imageUsuarioForm = filter_var($imageUsuarioForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($imageUsuarioForm !=='') { //Ha cambiado la imagen
            $cambiarImagen = true;
        }*/

       // echo '<pre>' . print_r($nombreUsuario !== $nombreUsuarioForm, TRUE) . '</pre>';
        //echo '<pre>' . print_r($nombreUsuarioForm, TRUE) . '</pre>';
        //echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

        $emailUsuarioForm = trim($datos['email'] ?? '');
        $emailUsuarioForm = filter_var($emailUsuarioForm, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!filter_var($emailUsuarioForm, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'El email tiene que ser un email válido.';
        }
        if ($_SESSION['nombre'] !== $emailUsuarioForm) { //Ha cambiado el email
            //$this->errores['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
            
            //Se busca si el nombre exitse
            $newEmailUsuarioForm = Usuario::buscaUsuario($emailUsuarioForm); 
            
            if ($newEmailUsuarioForm) {
                $this->errores[] = "El usuario ya existe (email)";
            }
            else{
                $cambiarEmail = true;
            }
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if($password === ''){
            $cambiarPassword = false;
        }
        else
        {
            if (mb_strlen($password) < 5 ) {
                $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
            }

            $password2 = trim($datos['password2'] ?? '');
            $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( !$password2 || $password !== $password2 ) {
                $this->errores['password2'] = 'Los passwords deben coincidir';
            }
            else{
                $cambiarPassword = true;
            }
        }

       

        if (count($this->errores) === 0) 
        {

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

            if($cambiarImagen)
            {
                $newImagen = $target_file;
            }
            else
            {
                $newImagen = $_SESSION['image'];
            }

            $usuario = Usuario::buscaUsuario($nombreUsuario);

            if($cambiarPassword)
            {
                $newPass = $password;
                //$newUsuario = Usuario::crea($usuario, $newNombre, $newPass, $newEmail);
                $newUsuario = Usuario::actualiza($usuario, $newNombre, $newImagen, $newEmail, Usuario::hashPassword($newPass));
            }
            else{
                $newUsuario = Usuario::actualizaSetting($usuario, $newNombre, $newEmail, $newImagen);
            }

            
            if ($newUsuario) {
                $app = Aplicacion::getInstance();
                $app->logout($usuario);
                $app->login($newUsuario);
            }
        }



    }



}
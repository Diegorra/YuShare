<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Comentario;
use es\ucm\fdi\aw\Pelicula;

class FormularioComent extends Formulario
{
    public function __construct($idPeli) {
        parent::__construct('formComent', [
            'formId' => "formComent",
            'urlRedireccion' => Aplicacion::getInstance()->resuelve(Aplicacion::getInstance()->buildUrl('/peliIndv.php', ['id'=> $idPeli]))
        ]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos([], $this->errores, 'span', array('class' => 'error'));

        // Se reutiliza el campo introducido previamente o se deja en blanco
        $coment_text = $datos['coment_text'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['coment_text'], $this->errores, 'span', array('class' => 'error'));

        $camposFormulario = <<<EOS
        $htmlErroresGlobales
        <h2>Añade tu comentario!<h2>
        <textarea id="coment_text" type="text" name="coment_text" placeholder="Escribe tu comentario..." value="$coment_text"> </textarea>
        {$erroresCampos['coment_text']}
        <button type="submit" id="comment_button">Comentar</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $app = Aplicacion::getInstance();
        $this->errores = [];
        $coment_text = trim($datos['coment_text'] ?? '');
        $coment_text = filter_var($coment_text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $coment_text || empty($coment_text) ) {
            $this->errores['coment_text'] = 'El comentario no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {
            $idPeli = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $idUsuario = $_SESSION['idUsuario'];
            $usuarios = Comentario::insertComentario($coment_text,$idPeli,$idUsuario);
            $this->errores[] = "Comentario creado correctamente";
        }
    }
}


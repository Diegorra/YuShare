<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Pelicula;

class FormularioComent extends Formulario
{
    public function __construct() {
        parent::__construct('formComent', [
            'formId' => "formComent",
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/peliIndv.php')
        ]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el campo introducido previamente o se deja en blanco
        $coment_text = $datos['coment_text'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['coment_text'], $this->errores, 'span', array('class' => 'error'));

        $camposFormulario = <<<EOS
        $htmlErroresGlobales
        <input id="coment_text" type="text" name="coment_text" placeholder="Escribe tu comentario..." value="$coment_text"/>
        {$erroresCampos['coment_text']}
        <button type="submit" id="search_button">Search</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();
        $this->errores = [];
        $search_text = trim($datos['coment_text'] ?? '');
        $search_text = filter_var($coment_text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $search_text || empty($coment_text) ) {
            $this->errores['coment_text'] = 'El comentario no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {
            $usuarios = Usuario::insertComentario($coment_text);
        }
    }
}


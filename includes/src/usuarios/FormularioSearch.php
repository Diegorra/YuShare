<?php

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioSearch extends Formulario
{
    public function __construct($formId, $class) {
        parent::__construct('formSearch', [
            'formId' => $formId,
            'class' => $class,
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/resultSearch.php')
        ]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el campo introducido previamente o se deja en blanco
        $search_text = $datos['search_text'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['search_text'], $this->errores, 'span', array('class' => 'error'));


        $camposFormulario = <<<EOS
        $htmlErroresGlobales
        <input id="search_text" type="text" name="search_text" placeholder="What are you looking for?" value="$search_text"/>
        {$erroresCampos['search_text']}
        <button type="submit" id="search_button">Search</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        //$app = Aplicacion::getInstance();
        $this->errores = [];
        $search_text = trim($datos['search_text'] ?? '');
        $search_text = filter_var($search_text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $search_text || empty($search_text) ) {
            $this->errores['search_text'] = 'El nombre de usuario no puede estar vacío';
        }
        
        /*
        $tituloPagina = 'Search';
        $contenidoPrincipal=<<<EOF
            <h1>Probando Search</h1>
            <p>{$search_text}</p>
        EOF;

        $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
        return $app->generaVista('/plantillas/plantilla.php', $params);
        
        
        /*
        $mensajes = ['Hasta pronto !'];
        $app->putAtributoPeticion('mensajes', $mensajes);
        $result = $app->resuelve('/resultSearch.php');

        return $result;*/
    }
}

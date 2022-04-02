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
        $keyWords = $datos['keyWords'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['keyWords'], $this->errores, 'span', array('class' => 'error'));


        $camposFormulario = <<<EOS
        $htmlErroresGlobales
        <input type="text" size="40" maxlength="150" name="search_text" placeholder="What are you looking for?" id="search_text" value="$keyWords"/>
        {$erroresCampos['keyWords']}
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
        $keyWords = trim($datos['keyWords'] ?? '');
        $keyWords = filter_var($keyWords, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $keyWords || empty($keyWords) ) {
            $this->errores['keyWords'] = 'El nombre de usuario no puede estar vacío';
        }
        
        /*
        $tituloPagina = 'Search';
        $contenidoPrincipal=<<<EOF
            <h1>Probando Search</h1>
            <p>{$keyWords}</p>
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

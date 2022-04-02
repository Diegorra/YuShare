<?php

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioSearch extends Formulario
{
    public function __construct() {
        parent::__construct('formSearch', [
            'action' =>  Aplicacion::getInstance()->resuelve('/search.php'),
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/resultSearch.php')]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $camposFormulario = <<<EOS
            <input type="text" size="40" maxlength="150" name="search_text" placeholder="What are you looking for?" id="search_text" />
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

        $app->logout();
        $mensajes = ['Hasta pronto !'];
        $app->putAtributoPeticion('mensajes', $mensajes);
        $result = $app->resuelve('/index.php');

        return $result;
    }
}

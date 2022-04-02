
<?php

use es\ucm\fdi\aw\usuarios\FormularioSearch;

function barraSearch()
{
    
    $formSearch = new FormularioSearch('search_form', 'clearfix');
    return $formSearch->gestiona();
}
?>
<!-- BARRA DE BUSQUEDA -->
<div class="cuerpo_peliculas">
    <?= barraSearch(); ?>
</div>

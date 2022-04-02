
<?php

use es\ucm\fdi\aw\usuarios\FormularioSearch;

function barraSearch()
{
    $formSearch = new FormularioSearch();
    return $formSearch->gestiona();
}
?>
<!-- BARRA DE BUSQUEDA -->
<div class="cuerpo_peliculas">
    <form id="search_form" class="clearfix">
        <?= barraSearch(); ?>
    </form>
</div>

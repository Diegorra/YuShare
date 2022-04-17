<?php
require_once __DIR__.'/includes/config.php';




//$formLogout = new \es\ucm\fdi\aw\usuarios\FormularioLogout();
//$formLogout->gestiona();
$app->logout();
$app->redirige('/yushare/index.php');
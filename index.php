<?php
require_once 'config/obsluga_sesji.php';
include_once 'config/menu.php';
$AKTYWNY="index.php";
$TRESC="To jest nasza pierwsza strona<br>" .PHP_EOL;
for ($i=0;$i<10;$i++){
    $TRESC.="To jest nasza pierwsza strona<br>" .PHP_EOL;
}

include_once 'szablony/witryna.php';
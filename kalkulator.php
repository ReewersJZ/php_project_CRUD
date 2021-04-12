<?php
require_once 'config/obsluga_sesji.php';
include_once 'config/menu.php';
$AKTYWNY="kalkulator.php";

$x = isset($_POST['x']) ? (float)$_POST['x'] : 0.0;
$y = isset($_POST['y']) ? (float)$_POST['y'] : 0.0;

$operator=isset($_POST['operator']) ? $_POST['operator'] : 0;

if (
    ($x || $x === 0.0) &&
    ($y || $y === 0.0) &&
    is_numeric($x) &&
    is_numeric($y)
    ) {
        switch($operator)
        {
            case '1': $wynik=$x+$y; break;
            case '2': $wynik=$x-$y; break;
            case '3': $wynik=$x/$y; break;
            case '4': $wynik=$x*$y; break;
            default: $wynik=0.0;
        }
    }
    else{
        $wynik=0.0;
    }
$TRESC[0]="szablony/kalkulator.php";

include_once 'szablony/witryna.php';
<?php
require_once '../config/obsluga_sesji.php';
require_once '../config/settings.php';
require_once '../include/Aktorzy.php';
require_once '../include/Obsada.php';

function callback($buffer) {
    return json_encode(array('success'=>$buffer));
}

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'){
    header('Content-Type: text/html; charset=utf-8');
    die('Dostęp zabroniony');
}
if(!isset($_GET['id_aktora'])){
    header('Location:aktorzy.php', true, 301);
    exit();
}
ob_start('callback');

$pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName;port=$DBPort", $DBUser, $DBPass);
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$aktorzy = new Aktorzy($pdo);
$AKTOR = $aktorzy->getAktor((int)$_GET['id_aktora']);
if($AKTOR == null){
    header('Location:aktorzy.php', true, 301);
    exit();
}

$obsada = new Obsada($pdo);
if($_GET['action'] != 'add'){
    $obsada->delete_aktor_movie($_GET['id_aktora'], $_GET['id_filmu']);
} else {
    $obsada->insert_obsada($_GET['id_aktora'], $_GET['id_filmu']);
}
$MOVIES=$aktorzy->getAktorMoviesInfo((int)$_GET['id_aktora']);

include_once '../szablony/lista_filmow.php';
ob_end_flush();
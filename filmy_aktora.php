<?php
require_once 'config/obsluga_sesji.php';
include_once 'config/menu.php';
require_once 'config/settings.php';
require_once 'include/Aktorzy.php';

$AKTYWNY = basename('aktorzy.php');
$TRESC = '';
$KOMUNIKAT = '';

if(!isset($_GET['id'])){
    header('Location:aktorzy.php', true, 301);
    exit();
}
$pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName;port=$DBPort", $DBUser, $DBPass);
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$aktorzy = new Aktorzy($pdo);
$AKTOR = $aktorzy->getAktor((int)$_GET['id']);

if($AKTOR == null){
    header('Location:aktorzy.php', true, 301);
    exit();
}
$MOVIES = $aktorzy->getAktorMoviesInfo((int)$_GET['id']);

$TRESC = array();
$TRESC[0] = 'szablony/filmy_aktora.php';
include_once 'szablony/witryna.php';
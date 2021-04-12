<?php
require_once 'config/obsluga_sesji.php';
include_once 'config/menu.php';
require_once 'config/settings.php';
require_once 'include/Aktorzy.php';

$AKTYWNY = basename(__FILE__);
$TRESC = "";
$KOMUNIKAT = "";


$pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName;port=$DBPort", $DBUser, $DBPass);
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$aktorzy = new Aktorzy($pdo);

// $aktorzy->insert('Adam', 'Turkot');

//  var_dump($aktorzy->getAktors('`imie`'));


$IMIE = '';
$NAZWISKO = '';
$ID = '';

if(isset($_SESSION['username'])) {
	if(isset($_GET['op']) && $_GET['op'] === '0'){ 
		//edycja
		$aktor = $aktorzy->getAktor((int)$_GET['id']);
		$IMIE = $aktor['imie'];
		$NAZWISKO = $aktor['nazwisko'];
		$ID = $aktor['id_aktora'];
	}
	if(isset($_GET['op']) && $_GET['op'] === '1'){
		//usun
		if(isset($_GET['id'])){
			$aktorzy->delete((int)$_GET['id']);
			if($aktorzy->getError()){
				$TRESC = $aktorzy->getErrorDescription();
				include_once 'szablony/witryna.php';
				exit();
			}
		}
	}
	if(isset($_POST['dodaj'])){
		//dodawanie nowej pozycji
		$aktorzy->insert($_POST['imie'], $_POST['nazwisko']);
		if($aktorzy->getError()){
				$TRESC = $aktorzy->getErrorDescription();
				include_once 'szablony/witryna.php';
				exit();
			}
	}
	if(isset($_POST['zmien'])){
		//modyfikowanie istniejacej pozycji
		$aktorzy->update($_POST['id'], $_POST['imie'], $_POST['nazwisko']);
		if($aktorzy->getError()){
				$TRESC = $aktorzy->getErrorDescription();
				include_once 'szablony/witryna.php';
				exit();
			}
	}
}
$AKTORZY = $aktorzy->getAktors();
// var_dump($AKTORZY);
$TRESC = array();
$TRESC[0] = 'szablony/aktorzy.php';
include_once 'szablony/witryna.php';

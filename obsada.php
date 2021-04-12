<?php
require_once 'config/obsluga_sesji.php';
include_once 'config/menu.php';
require_once 'config/settings.php';
require_once 'include/Obsada.php';

$AKTYWNY = basename(__FILE__);
$TRESC = "";
$KOMUNIKAT = "";


$pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName;port=$DBPort", $DBUser, $DBPass);
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$obsada = new Obsada($pdo);

$AKTOR_OBSADA = '';
$FILM_OBSADA = '';
$ID_AKTORA = '';
$ID_FILMU = '';
$ID_OBSADY = '';


if(isset($_SESSION['username'])) {
	if(isset($_GET['op']) && $_GET['op'] === '0'){ 
		//edycja
		$aktor_obsada = $obsada->getAktor_obsada((int)$_GET['id_obsady']);
        $AKTOR_OBSADA = $aktor_obsada['imie']. " ". $aktor_obsada['nazwisko'];
        $FILM_OBSADA = $aktor_obsada['tytul'];
		$ID_AKTORA = $aktor_obsada['id_aktora'];
		$ID_FILMU = $aktor_obsada['id_filmu'];
		$ID_OBSADY = $aktor_obsada['id_obsady'];
	}
	if(isset($_GET['op']) && $_GET['op'] === '1'){
		//usun
		if(isset($_GET['id_obsady'])){
			$obsada->delete_obsada((int)$_GET['id_obsady']);
			if($obsada->getError()){
				$TRESC = $obsada->getErrorDescription();
				include_once 'szablony/witryna.php';
				exit();
			}
		}
	}
	if(isset($_POST['dodaj'])){
		//dodawanie nowej pozycji
		$obsada->insert_obsada($_POST['id_aktora'], $_POST['id_filmu']);
		if($obsada->getError()){
				$TRESC = $obsada->getErrorDescription();
				include_once 'szablony/witryna.php';
				exit();
			}
	}
	if(isset($_POST['zmien'])){
		//modyfikowanie istniejacej pozycji
		$obsada->update_obsada($_POST['id_obsady'], $_POST['id_aktora'], $_POST['id_filmu']);
		if($obsada->getError()){
				$TRESC = $obsada->getErrorDescription();
				include_once 'szablony/witryna.php';
				exit();
			}
	}
}

$AKTORZY = $obsada->getAktors_list();
$FILMY = $obsada->getFilmy_list();
$OBSADA = $obsada->getAktors_obsada();
$TRESC = array();
$TRESC[0] = 'szablony/obsada.php';
include_once 'szablony/witryna.php';



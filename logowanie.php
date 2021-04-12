<?php
require_once 'config/obsluga_sesji.php';
include_once 'config/menu.php';
require_once 'config/settings.php';

$AKTYWNY="logowanie.php";
$TRESC="";
$LOGIN="";
$KOMUNIKAT = "";

if (isset($_POST['submit'])){
    if ($_POST['submit']==="Zaloguj"){
        if (
            (isset($_POST['login']) && $_POST['login'] !== "")
            && (isset($_POST['password']) && $_POST['password'] !== "")
            ){
            try
	        {
            $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName;port=$DBPort", $DBUser, $DBPass);
			$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$stmt = $pdo -> prepare(
                'SELECT 
                    `pracownicy`.`imie`,
                    `pracownicy`.`nazwisko`,
                    `pracownicy`.`haslo`
                FROM `pracownicy` 
                WHERE `pracownicy`.`login`=:login
                ');	

			$stmt->bindValue(':login', $_POST['login']);
			$result = $stmt -> execute(); 
            if ($stmt->rowCount()>1) throw new PDOException("Błąd w bazie danych. Więcej niż jeden użytkownik o takim samym loginie");
            if ($stmt->rowCount()==0){
                $KOMUNIKAT="Podano błędny login. Spróbuj jeszcze raz.";
                $LOGIN=$_POST['login'];
                $TRESC= array();
                $TRESC[0]="szablony/logowanie.php";
            }
            else{
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row['haslo'] == md5($_POST['password'].$TAJNY_KLUCZ)){
                    $_SESSION['username'] = $row['imie'] . ' ' . $row['nazwisko'];
                    $KOMUNIKAT = 'Witaj ' . $_SESSION['username'];
                    $TRESC = array();
                    $TRESC[0] = 'szablony/logowanie.php';
                } else {	
                    $KOMUNIKAT = 'Podano błędne hasło. Spróbuj jeszcze raz.';
                    $LOGIN = $_POST['login'];
                    $TRESC = array();
                    $TRESC[0] = 'szablony/logowanie.php';
                }
            }

            $stmt->closeCursor();
    }
	catch(PDOException $e)
	{
		$TRESC.= 'Wystapil blad biblioteki PDO: ' . $e->getMessage();
	}
            }
        else{
            $KOMUNIKAT="Podaj swoje dane do logowania.";
            $TRESC= array();
            $TRESC[0]="szablony/logowanie.php";
        }

    }
    else if($_POST['submit']==="Wyloguj"){
        if (isset($_SESSION['username'])) {
            unset($_SESSION['username']);
            $KOMUNIKAT="Zostałeś wylogowany.";
        }
        $TRESC= array();
        $TRESC[0]="szablony/logowanie.php";
    }
}
else{
    if (isset($_SESSION['username'])) {
        $KOMUNIKAT='Witaj ' . $_SESSION['username'];
    }
    $TRESC = array();
    $TRESC[0] = 'szablony/logowanie.php';

}

include_once 'szablony/witryna.php';
<?php
require_once 'config/obsluga_sesji.php';
include_once 'config/menu.php';
require_once 'config/settings.php';
$AKTYWNY="wypozyczenia.php";
$TRESC = "";

try
	{
            $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName;port=$DBPort", $DBUser, $DBPass);
			$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$stmt = $pdo -> prepare(
                'SELECT 
                    `klienci`.`imie`,
                    `klienci`.`nazwisko`, 
                    COUNT(`wypozyczenia`.`id_kopii`) as  liczba_wypozyczen 
                FROM `klienci`, `wypozyczenia` 
                WHERE `klienci`.`id_klienta`=`wypozyczenia`.`id_klienta` 
                GROUP BY `klienci`.`id_klienta` 
                ORDER by liczba_wypozyczen DESC;');	

			
			$result = $stmt -> execute(); 
            $rows=$stmt->fetchAll();
            
            $TRESC.="Lista wypożyczeń klientów: <br/>";
            $TRESC.="<ul>";
                foreach ($rows as $row){
                    $TRESC.="<li> Klient: " . $row['imie']." ". $row['nazwisko']. " Liczba wypożyczeń: ". $row['liczba_wypozyczen']. "</li>". PHP_EOL;
                }
            $TRESC.="</ul>";
            $stmt->closeCursor();
    }
	catch(PDOException $e)
	{
		$TRESC.= 'Wystapil blad biblioteki PDO: ' . $e->getMessage();
	}

include_once 'szablony/witryna.php'; 
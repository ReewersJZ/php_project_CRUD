<?php
require_once 'config/obsluga_sesji.php';
include_once 'config/menu.php';
require_once 'config/settings.php';
$AKTYWNY="oferta.php";
$TRESC = "";

try
	{
            $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName;port=$DBPort", $DBUser, $DBPass);
			$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$stmt = $pdo -> prepare(
                'SELECT 
                    `filmy`.`tytul`,
                    `filmy`.`rok_produkcji`, 
                    COUNT(`kopie`.`id_kopii`) as  liczba_kopii 
                FROM `filmy`, `kopie` 
                WHERE `filmy`.`id_filmu`=`kopie`.`id_filmu` 
                GROUP BY `filmy`.`id_filmu` 
                ORDER by liczba_kopii DESC;');	

			
			$result = $stmt -> execute(); 
            $rows=$stmt->fetchAll();
            
            $TRESC.="Lista wypożyczeń klientów: <br/>";
            $TRESC.="<ul>";
                foreach ($rows as $row){
                    $TRESC.="<li> Film: " . $row['tytul']." ". $row['rok_produkcji']. " Liczba kopii: ". $row['liczba_kopii']. "</li>". PHP_EOL;
                }
            $TRESC.="</ul>";
            $stmt->closeCursor();
    }
	catch(PDOException $e)
	{
		$TRESC.= 'Wystapil blad biblioteki PDO: ' . $e->getMessage();
	}

include_once 'szablony/witryna.php'; 
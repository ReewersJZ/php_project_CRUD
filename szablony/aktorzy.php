<?php
if (isset($_SESSION['username']))
    {
?>

    <form action="aktorzy.php" method="post">
    <input type="text" name="imie" title="Imię" value="<?=$IMIE?>">
    <input type="text" name="nazwisko" title="nazwisko" value="<?=$NAZWISKO?>">
    <input type="hidden" name="id" value="<?=$ID?>">
    <input type="submit" name="dodaj"  value="Dodaj">
    <input type="submit" name="zmien" value="Zapisz zmiany">
    </form>

<?php
    }
?>

    <div id="aktors_list">

<?php
	foreach ($AKTORZY as $aktor){

		echo '<div class="w3-panel w3-card-4"><p>';
		echo $aktor['imie']." ".$aktor['nazwisko'];
		if (isset($_SESSION['username'])){
            echo '<a class="w3-button w3-red w3-circle w3-margin-right w3-margin-bottom w3-right" title="Edytuj filmy w których występował aktor" href="filmy_aktora.php?id='.$aktor['id_aktora'].'">Filmy</a>';
			echo '<a class="w3-button w3-purple w3-circle w3-right w3-margin-right" href="aktorzy.php?op=0&id='.$aktor['id_aktora'].'" title="Zmień">!</a>';
			echo '<a class="w3-button w3-red w3-circle w3-right w3-margin-right" title="Usuń" href="aktorzy.php?op=1&id='.$aktor['id_aktora'].'" title="Usuń">x</a>';
            
		}
		echo "</p></div>";
	}
?>



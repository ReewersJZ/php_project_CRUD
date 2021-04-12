<?php
if (isset($_SESSION['username']))
    {
?>
    <form action="obsada.php" method="post">
    <select id="id_aktora" name="id_aktora" title="Aktor">
    <?php
    foreach ($AKTORZY as $aktor){
        $selected=($ID_AKTORA==$aktor['id_aktora'])?" selected ":"";
        echo '<option value="'.$aktor['id_aktora'].'""'.$selected.'>'.$aktor["imie"].' '.$aktor["nazwisko"].'</option>'.PHP_EOL;
    }
    ?>
    </select>

    <select id="id_filmu" name="id_filmu" title="Film">
    <?php
    foreach ($FILMY as $film){
        $selected=($ID_FILMU==$film['id_filmu'])?" selected ":"";
        echo '<option value="'.$film['id_filmu'].'""'.$selected.'>'.$film["tytul"].'</option>'.PHP_EOL;
    }
    ?>
    </select>

    <input type='hidden' name='id_obsady' value='<?=$ID_OBSADY?>'>
    <input type="submit" name="dodaj"  value="Dodaj">
    <input type="submit" name="zmien" value="Zapisz zmiany">
    </form>
<?php
    }
?>

    <div id="obsada_list">

<?php
    echo '<div class="w3-responsive" style="margin-top:5%;">
    <table class="w3-table-all w3-card-4">';
    if (isset($_SESSION['username'])) 
        {$trzecia_kloumna = '<th></th>';}
    else {$trzecia_kloumna="";}
    echo '<tr><th>Aktor</th><th>Film</th>' .$trzecia_kloumna. '</tr>'. PHP_EOL;

	foreach ($OBSADA as $obs){

        echo "<tr>";
        echo "<td>" .$obs['imie']. " " . $obs['nazwisko']. "</td><td>". $obs['tytul']. "</td>";
        echo "<input type='hidden' name='id_obsady' value=" .$obs['id_obsady']. ">"; 

		if (isset($_SESSION['username'])){
            echo '<td>';
			echo '<a class="w3-button w3-purple w3-circle w3-right w3-margin-right" href="obsada.php?op=0&id_obsady='.$obs['id_obsady'].'" title="Zmień">!</a>';
			echo '<a class="w3-button w3-red w3-circle w3-right w3-margin-right" title="Usuń" href="obsada.php?op=1&id_obsady='.$obs['id_obsady'].'" title="Usuń">x</a>';
            echo '</td>';
		}
		echo "</tr>". PHP_EOL;
	}
    echo "</table></div>";
?>

</div>



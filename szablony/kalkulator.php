<form action="kalkulator.php" method="post">
		<input type='text' name="x" title="pierwsza liczba" value="<?=$x?>">
		<select name="operator">
			<option value="1" <?php if ($operator==1) echo "selected"?>>+</option>
			<option value="2" <?php if ($operator==2) echo "selected"?>>-</option>
			<option value="3" <?php if ($operator==3) echo "selected"?>>/</option>
			<option value="4" <?php if ($operator==4) echo "selected"?>>*</option>
		</select> <input type='text' name="y" title="druga liczba" value="<?=$y?>">
		<input type="submit">
	</form>
	Wynik operacji: <?=$wynik?>
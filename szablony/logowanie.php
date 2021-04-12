
<p><?=$KOMUNIKAT?></p>
<?php if(isset($_SESSION['username'])){
    ?> 
    <form action="logowanie.php" method="post">
        <input type="submit" name="submit" value="Wyloguj">
    </form>

    <?php
    }
    else{?>
    Użytkownik "smith", hasło: "zaq12wsx"
    <form action="logowanie.php" method="post">
        Login:
        <input type='text' name="login" title="Podaj swój login" value="<?=$LOGIN?>">
        Hasło:
        <input type='text' name="password" title="Wprowadź hasło" value="">
        <input type="submit" name="submit" value="Zaloguj">
    </form>
   
<?php
    }
?>


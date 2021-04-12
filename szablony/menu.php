
 <?php
foreach ($MENU as $href => $wyswietlany_opis)
{
    if ($AKTYWNY==$href){
        echo "<a class='w3-bar-item w3-button w3-teal' href='$href'>$wyswietlany_opis</a>";
    }
    else{
        echo "<a class='w3-bar-item w3-button' href='$href'>$wyswietlany_opis</a>";
    }
    
}


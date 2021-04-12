<style>
    #message {
        box-sizing: border-box;
        display: none;
        width: 300px;
        padding: 10px 20px;
        margin: 0 auto;
        border-radius: 10px;
        border: 1px solid #000;

        line-height: 22px;
        text-align: center;
    }
    #message.error {
        display: block;
        border-color: #fa7382;
        color: #fa3543;
    }
    #message.success {
        display: block;
        border-color: #9ffa8a;
        color: #4be542;
    }
</style>
<div id="message"></div>
<?php
    if(isset($_SESSION['username'])){
?>
<p>
Aktor: <?=$AKTOR['imie']?> <?=$AKTOR['nazwisko']?>
</p>
<?php
    }
?>
<div id="aktor_movies" data-id_aktora="<?=$AKTOR['id_aktora']?>">
<?php
require_once 'szablony/lista_filmow.php';
?>
</div>
<script src="js/ajax.js" defer></script>
<script src="js/script.js" defer></script>
<a href="aktorzy.php" class="w3-button w3-black">Wróć</a>
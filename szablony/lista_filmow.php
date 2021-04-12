<style>
    .table {
        display; table;
    }
    .row {
        display: table-row;
    }
    .td {
        display: table-cell;
        padding: 1em;
    }
</style>
<div class="table">
    <div class="row">
        <div class="td">
            <b>Filmy w których występował(a)</b><br>
            <select id="aktor_movies_in" size="5">
                <?php
                    foreach($MOVIES['IN'] as $movie){
                        echo '<option onClick="SwapMovie(this,\'delete\');" value="'.$movie['id_filmu'].'">'.$movie['tytul'].'</option>'.PHP_EOL;
                    }
                ?>
            </select>
        </div>
        <div class="td">
            <b>Filmy w których nie występował(a)</b><br>
            <select id="aktor_movies_notin" size="5">
                <?php
                    foreach($MOVIES['NOTIN'] as $movie){
                        echo '<option onClick="SwapMovie(this,\'add\');" value="'.$movie['id_filmu'].'">'.$movie['tytul'].'</option>'.PHP_EOL;
                    }
                ?>
            </select>
        </div>
    </div>
</div>
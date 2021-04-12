<?php

/**
 * @author Justyna Zahraj
 * Klasa obsługi czynności związanych z tabelą aktorzy
 */

 class Aktorzy
 {
    private $pdo;
    private $is_error;
    private $error_description;
    public $aktors_array;


    /**
    * Konstruktor klasy
    * @param PDO object $pdo
    */
    public function __construct($pdo){
        $this->pdo=$pdo;
        $this->is_error=FALSE;
    }

    /**
    * Metoda dodająca nowy rekord do bazy danych
    * @param string $imie
    * @param string $nazwisko
    */
    public function insert($imie, $nazwisko){
        if ($this->pdo==null){
            $this->is_error=TRUE;
            $this->error_description="Brak połaczenia z bazą danych";
            return;
        }
        try{
            $stmt = $this->pdo -> prepare('INSERT INTO `aktorzy` (`imie`, `nazwisko`) VALUES (:imie, :nazwisko);');
            $stmt->bindValue(':imie', $imie, PDO::PARAM_STR);
            $stmt->bindValue(':nazwisko', $nazwisko, PDO::PARAM_STR);
            $result = $stmt ->execute();
            if ($result==true){
                $this->is_error=FALSE;
                $this->error_description='';
            }
            $stmt->closeCursor();
        }
        catch (PDOException $e){
            $this->is_error=TRUE;
            $this->error_description="nie udało się dodać rekordu do bazy danych: ". $e->getMessage();
            return;
        }
    }
 
    /**
     * modyfikowanie rekordu o opodanym id
     * @param int $id
     * @param string $imie
     * @param string $nazwisko
    */
    public function update($id, $imie, $nazwisko)
    {
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $stmt = $this->pdo -> prepare('UPDATE aktorzy SET
                                                imie=:imie,
                                                nazwisko=:nazwisko 
                                            WHERE id_aktora=:id_aktora');
            $stmt->bindValue(':id_aktora', $id, PDO::PARAM_INT);
            $stmt->bindValue(':imie', $imie, PDO::PARAM_STR);
            $stmt->bindValue(':nazwisko', $nazwisko, PDO::PARAM_STR);
            $result = $stmt -> execute();
            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się zmienić danych aktora: '. $e->getMessage();
            return;
        }
    }
    /**
     * usuwanie rekordu o podanym id
     * @param int $id
    */
    public function delete($id)
    {
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $stmt = $this->pdo -> prepare('DELETE FROM aktorzy
                                            WHERE id_aktora=:id_aktora');
            $stmt->bindValue(':id_aktora', $id, PDO::PARAM_INT);
            $result = $stmt -> execute();
            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się usunąć aktora.';//$e->getMessage();
            return;
        }
    }

    /**
     * pobieranie listy aktorow
     * @param string $order_by default nazwisko - kolumna względem której ma być sortowana
     * @param bool $narastajaco default true - czy sortowac narastająco
    */
    public function getAktors($order_by='nazwisko', $narastajaco = TRUE)
    {
        $this->aktors_array = array();
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $query = 'SELECT id_aktora, imie, nazwisko FROM aktorzy ';
            $query .= 'ORDER BY '.$order_by;
            if($narastajaco)
                $query .= ' ASC ';
            else
                $query .= ' DESC ';

            $stmt = $this->pdo -> prepare($query);
            $result = $stmt -> execute();
            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
                $this->aktors_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się odczytać danych z bazy: '. $e->getMessage();
            return;
        }
        return $this->aktors_array;
    }
    /**
     * pobieranie rekordu o podanym id
     * @param int $id
    */
    public function getAktor($id)
    {
        $this->aktors_array = array();
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $stmt = $this->pdo -> prepare('SELECT id_aktora, imie, nazwisko FROM aktorzy
                                            WHERE id_aktora=:id_aktora');
            $stmt->bindValue(':id_aktora', $id, PDO::PARAM_INT);
            $result = $stmt -> execute();

            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
                $this->aktors_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się odczytać danych aktora: '. $e->getMessage();
            return;
        }
        return $this->aktors_array[0];
    }
    /**
     * pobieranie statusu bledu
    */
    public function getError()
    {
        $error = $this->is_error;
        $this->is_error = FALSE;
        return $error;
    }
    /**
     * pobieranie opisu blędu
    */
    public function getErrorDescription()
    {
        $error_description = $this -> error_description;
        $this -> error_description = '';
        return $error_description;
    }

    /**
     * pobieranie filmów w których wystąpił bądź nie aktor
     */
    public function getAktorMoviesInfo($id){
        $aktor_movies_info = array();
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $stmt = $this->pdo -> prepare('SELECT DISTINCT(id_filmu), tytul FROM filmy NATURAL JOIN obsada
                                            WHERE id_aktora = :id_aktora ORDER BY tytul');
            $stmt->bindValue(':id_aktora', $id, PDO::PARAM_INT);
            $result = $stmt -> execute();

            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
                $aktor_movies_info['IN'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $stmt->closeCursor();
            $stmt = $this->pdo -> prepare('SELECT id_filmu, tytul FROM filmy
                                            WHERE id_filmu NOT IN (SELECT DISTINCT (id_filmu) FROM filmy NATURAL JOIN obsada
                                            WHERE id_aktora = :id_aktora) ORDER BY tytul');
            $stmt->bindValue(':id_aktora', $id, PDO::PARAM_INT);
            $result = $stmt -> execute();

            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
                $aktor_movies_info['NOTIN'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się odczytać danych: '. $e->getMessage();
            return;
        }
        /*
        echo '<br><br>';
        var_dump($aktor_movie_info);
        tablica jest zwracana prawidłowo
        */
        return $aktor_movies_info;

    }
 }
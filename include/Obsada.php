<?php

/**
 * @author Justyna Zahraj
 * Klasa obsługi czynności związanych z tabelą obsada
 */

 class Obsada
 {
    private $pdo;
    private $is_error;
    private $error_description;
    public $obsada_array;
    public $aktors_list_array;
    public $films_list_array;

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
    * @param int $id_aktora
    * @param int $id_filmu
    */
    public function insert_obsada($id_aktora, $id_filmu){
        if ($this->pdo==null){
            $this->is_error=TRUE;
            $this->error_description="Brak połaczenia z bazą danych";
            return;
        }
        try{
            $stmt = $this->pdo -> prepare('INSERT INTO `obsada` (`id_aktora`, `id_filmu`) VALUES (:id_aktora, :id_filmu);');
            $stmt->bindValue(':id_aktora', $id_aktora, PDO::PARAM_INT);
            $stmt->bindValue(':id_filmu', $id_filmu, PDO::PARAM_INT);
            $result = $stmt ->execute();
            if ($result==true){
                $this->is_error=FALSE;
                $this->error_description='';
            }
            echo "<script language='javascript' type='text/javascript'>alert('Dane zapisane do bazy.');</script>";
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
     * @param int $id_obsady
     * @param int $id_aktora
     * @param int $id_filmu
    */
    public function update_obsada($id_obsady, $id_aktora, $id_filmu)
    {
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $stmt = $this->pdo -> prepare('UPDATE obsada SET
                                                id_aktora=:id_aktora,
                                                id_filmu=:id_filmu 
                                            WHERE id_obsady=:id_obsady');
            $stmt->bindValue(':id_obsady', $id_obsady, PDO::PARAM_INT);
            $stmt->bindValue(':id_aktora', $id_aktora, PDO::PARAM_INT);
            $stmt->bindValue(':id_filmu', $id_filmu, PDO::PARAM_INT);
            $result = $stmt -> execute();
            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
            }
            echo "<script language='javascript' type='text/javascript'>alert('Dane zmodyfikowane.');</script>";
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się zmienić danych obsady: '. $e->getMessage();
            return;
        }
    }

    /**
     * usuwanie rekordu o podanym id
     * @param int $id_obsady
    */
    public function delete_obsada($id_obsady)
    {
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $stmt = $this->pdo -> prepare('DELETE FROM obsada
                                            WHERE id_obsady=:id_obsady');
            $stmt->bindValue(':id_obsady', $id_obsady, PDO::PARAM_INT);
            $result = $stmt -> execute();
            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
            }
            echo "<script language='javascript' type='text/javascript'>alert('Pozycja o ID: ".$id_obsady." usunięta z bazy.');</script>";
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się usunąć obsady.';//$e->getMessage();
            return;
        }
    }

    /**
		 * usuwanie rekordu z tabeli obsada dla id_aktora i id_filmu
		 * @param int $id_aktora
		 * @param int $id_filmu
		*/
		public function delete_aktor_movie($id_aktora, $id_filmu)
		{
			if($this->pdo == null){
				$this->is_error = TRUE;
				$this->error_description = 'Brak połączenia z bazą';
				return;
			}
			try {
				$stmt = $this->pdo -> prepare('DELETE FROM obsada
												WHERE id_aktora=:id_aktora AND id_filmu = :id_filmu');
				$stmt->bindValue(':id_aktora', $id_aktora, PDO::PARAM_INT);
				$stmt->bindValue(':id_filmu', $id_filmu, PDO::PARAM_INT);
				$result = $stmt -> execute();
				if($result == true){
					$this->is_error = FALSE;
					$this->error_description = '';
				}
				$stmt->closeCursor();
			}
			catch(PDOException $e){
				$this->is_error = TRUE;
				$this->error_description = 'Nie udało się usunąć obsady: '. $e->getMessage();
				return;
			}
		}

    /**
     * pobieranie listy aktorow w połaczeniu z filmem
     * @param string $order_by default nazwisko - kolumna względem której ma być sortowana
     * @param bool $narastajaco default true - czy sortowac narastająco
    */

    public function getAktors_obsada($order_by='nazwisko', $narastajaco = TRUE)
    {
        $this->obsada_array = array();
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {

            $query = "SELECT id_obsady, imie, nazwisko, tytul, id_aktora, id_filmu FROM obsada natural join aktorzy natural join filmy ";
            
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
                $this->obsada_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się odczytać danych z bazy: '. $e->getMessage();
            return;
        }
        return $this->obsada_array;
    }
    /**
     * pobieranie rekordu o podanym id_obsady
     * @param int $id_obsady
    */
    public function getAktor_obsada($id_obsady)
    {
        $this->obsada_array = array();
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $stmt = $this->pdo-> prepare('SELECT id_obsady, imie, nazwisko, tytul, id_aktora, id_filmu FROM obsada natural join aktorzy natural join filmy WHERE id_obsady=:id_obsady');

            $stmt->bindValue(':id_obsady', $id_obsady, PDO::PARAM_INT);
            $result = $stmt -> execute();

            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
                $this->obsada_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się odczytać danych aktora: '. $e->getMessage();
            return;
        }
        return $this->obsada_array[0];
    }

    /**
     * pobieranli listy aktorów
     */
    public function getAktors_list()
    {
        $this->aktors_list_array = array();
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $stmt = $this->pdo-> prepare('SELECT * FROM aktorzy');
            $result = $stmt -> execute();

            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
                $this->aktors_list_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się odczytać danych aktora: '. $e->getMessage();
            return;
        }
        return $this->aktors_list_array;
    }

        /**
     * pobieranli listy filmów
     */
    public function getFilmy_list()
    {
        $this->films_list_array = array();
        if($this->pdo == null){
            $this->is_error = TRUE;
            $this->error_description = 'Brak połączenia z bazą';
            return;
        }
        try {
            $stmt = $this->pdo-> prepare('SELECT * FROM filmy');
            $result = $stmt -> execute();

            if($result == true){
                $this->is_error = FALSE;
                $this->error_description = '';
                $this->films_list_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e){
            $this->is_error = TRUE;
            $this->error_description = 'Nie udało się odczytać danych aktora: '. $e->getMessage();
            return;
        }
        return $this->films_list_array;
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
 }

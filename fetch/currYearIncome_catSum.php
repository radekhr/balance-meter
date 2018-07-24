<?php
include "../class/user.php";
session_start();
$iduser = $_SESSION['zalogowany']->id;
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);//sposob raportowania bledow

        try
        {
            $polaczenie = mysqli_connect($host, $user, $password, $database);
            if($polaczenie->connect_errno!=0)
                throw new Exception(mysqli_connect_errno());
            else
            {  
                $zapytanie = "SELECT ROUND(SUM(kwota),2) AS 'Suma', wynagrodzenie FROM przychody WHERE iduzytkownika ='$iduser' AND YEAR(data) = YEAR(CURRENT_DATE) GROUP BY wynagrodzenie";
                $rezultat = mysqli_query($polaczenie,$zapytanie);
                
                $wyjscie = array(); //tablicowe
                
                while($wiersz = mysqli_fetch_assoc($rezultat)){
                    $wyjscie[] = $wiersz;
                }
            }
        }catch(Exception $e){
            echo '<span style="color:red;">Błąd serwera! Przepraszamy!</span>';
            echo '<br/>Informacja dev: '.$e;
        }

echo json_encode($wyjscie);

?>
<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność imienia
		$imie = $_POST['imie'];
		
		//Sprawdzenie długości imienia
		if ((strlen($imie)==0))
		{
			$wszystko_OK=false;
			$_SESSION['e_imie']="Musisz podać Twoje imię!";
		}
		//Sprawdź poprawność nazwiska
		$nazwisko = $_POST['nazwisko'];
		
		//Sprawdzenie długości nazwiska
		if ((strlen($nazwisko)==0))
		{
			$wszystko_OK=false;
			$_SESSION['e_nazwisko']="Musisz podać Twoje nazwisko!";
		}
		
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		//Poprawność peselu
		$pesel = $_POST['pesel'];
		
		if (!(strlen($pesel)==11))
		{
			$wszystko_OK=false;
			$_SESSION['e_pesel']="Pesel musi zawierać jedenaście liczb!";
		}
		
		
		//Czy zaakceptowano regulamin?
		if ((!isset($_POST['regulamin'])))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_imie'] = $imie;
		$_SESSION['fr_nazwisko'] = $nazwisko;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_pesel'] = $pesel;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "dane_do_logowania_baza.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
			
			$polaczenie = new mysqli($adresbazy, $db_login, $db_passowrd, $bazadanych);
			$polaczenie -> query ('SET NAMES utf8');
			$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT * FROM logowanie WHERE email='$email'");
				if (!$rezultat) throw new Exception($polaczenie->error);
			
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		
				//Czy pesel jest już?
				$rezultat = $polaczenie->query("SELECT * FROM logowanie WHERE pesel='$pesel'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_peseli = $rezultat->num_rows;
				if($ile_takich_peseli>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_pesel']="Istnieje już pesel. Prosze sprawdzić swój pesel ";
				}
				
				echo $wszystko_OK;
				
				if($wszystko_OK==true)
				{	
						//echo $wszystko_OK;
					if($polaczenie->query("INSERT INTO logowanie VALUES (NULL, '$imie','$nazwisko','$email', '$haslo_hash', 0, '$pesel',0,0,0,0,0)"))
					{
						$_SESSION['udanarejestracja']="Gratulacje, zostałeś zarejestrowany!";
											if($_POST['specjalnykod']=='4264')
											{
											$nauczyciel = $polaczenie->query(sprintf("UPDATE logowanie SET czy_nauczyciel = '1' WHERE email='$email'"));
											
											}
								unset($_SESSION['fr_imie']);
								unset($_SESSION['fr_nazwisko']);
								unset($_SESSION['fr_email']);
								unset($_SESSION['fr_pesel']);					
								
								$polaczenie->close();	
					}
			}
	header('Location: index.php');
	}	
}
?>
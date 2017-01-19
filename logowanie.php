<?php
	session_start();
		
	if((!isset($_POST["email"]))|| (!isset($_POST["haslo"])))
	{
		header('location:index.php');
		exit();
		}
	require_once"dane_do_logowania_baza.php";
	

	$polaczeniezbaza=@new mysqli($adresbazy, $db_login,$db_password, $bazadanych);
	$polaczeniezbaza -> query ('SET NAMES utf8');
	$polaczeniezbaza -> query ('SET CHARACTER_SET utf8_unicode_ci');
	if($polaczeniezbaza->connect_errno!=0)
	{
		echo"Error: ".$polaczeniezbaza->connect_errno;
		}
		else
	{
echo "123";				
		$email=$_POST["email"];
		$haslo=$_POST["haslo"];
		
		$email=htmlentities($email, ENT_QUOTES, "UTF-8");
		
		if($zapytanieouzytkownika = @$polaczeniezbaza->query(sprintf("SELECT * FROM logowanie WHERE email='%s'",
		mysqli_real_escape_string($polaczeniezbaza,$email))))
		
		{
			
				$ilewynikow =  $zapytanieouzytkownika->num_rows;
					
					if($ilewynikow>0)
						{

						$wynik = $zapytanieouzytkownika->fetch_assoc();
						$_SESSION['nauczyciel'] = $wynik['czy_nauczyciel'];
							if(password_verify($haslo, $wynik['haslo']))
							{
								$_SESSION['zalogowany'] = true;
								$_SESSION['id'] = $wynik['ID'];
								$_SESSION['imie'] = $wynik['imie'];
								$_SESSION['nazwisko'] = $wynik['nazwisko'];
								$nauczyciel = $wynik['czy_nauczyciel'];
								if($nauczyciel== 1)
									{
										header('Location: e-dziennik.php');
									}
								else
									{
										$_SESSION['pesel'] = $wynik['pesel'];
										$_SESSION['klasa'] = $wynik['klasa'];
										$_SESSION['matematyka'] = $wynik['matematyka'];
										$_SESSION['jpolski'] = $wynik['jpolski'];
										$_SESSION['jangielski'] = $wynik['jangielski'];
										$_SESSION['jniemiecki'] = $wynik['jniemiecki'];
										$_SESSION['informatyka'] = $wynik['informatyka'];
										header('Location: e-dziennik.php');
									}
							}
							else
								{
									$_SESSION['blad'] ='<span style="color:red"> Nieprawidłowe hasło</span>';
							header('location: index.php');
									
									}
							}

						
			
					else
						{
							$_SESSION['blad'] ='<span style="color:red"> Nieprawidłowy e-mail</span>';
							header('location: index.php');
			
						}
		}
	$polaczeniezbaza->close();	
	}
	
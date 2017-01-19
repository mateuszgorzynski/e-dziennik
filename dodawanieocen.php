<?php
	session_start();
	
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('location: index.php');
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
			
			$pesel=trim($_POST["peselucznia"]);
			$matematyka=$_POST["matematyka"];
			$jangielski=$_POST["jangielski"];
			$jpolski=$_POST["jpolski"];
			$informatyka=$_POST["informatyka"];
			$jniemiecki=$_POST["jniemiecki"];
			$pesel=htmlentities($pesel, ENT_QUOTES, "UTF-8");
		
		if($zapytanieouzytkownika = @$polaczeniezbaza->query(sprintf("SELECT * FROM logowanie WHERE pesel='$pesel'")))
			{		
				
				$ilewynikow =  $zapytanieouzytkownika->num_rows;
					
					if($ilewynikow>0)
						{	
						$zapytanie = @$polaczeniezbaza->query(sprintf("UPDATE logowanie SET matematyka = '$matematyka' , jpolski = '$jpolski' , jangielski= '$jangielski' , informatyka = '$informatyka' , jniemiecki= '$jniemiecki' WHERE pesel='$pesel'"));
							
							
								$_SESSION['dodano'] ='<span style="color:red"> Dodano Oceny!</span>';
								header('location: e-dziennik.php');
						
					}
			
					else
			{
				$_SESSION['blad'] ='<span style="color:red"> Nieprawidłowy pesel!</span>';
				header('location: e-dziennik.php');
			
			}
					
			
			
			}
		



			$polaczeniezbaza->close();
		}
?>
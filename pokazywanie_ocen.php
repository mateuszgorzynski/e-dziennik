<?php
		session_start();
		
		$_SESSION['wyswietlanie_ocen']=true;
		
		//var_dump($_POST);
		//var_dump($a);
		$wybor = $_POST["nazwa"];
		
		
		require_once"dane_do_logowania_baza.php";

			$polaczeniezbaza=@new mysqli($adresbazy, $db_login,$db_password, $bazadanych);
			$polaczeniezbaza -> query ('SET NAMES utf8');
			$polaczeniezbaza -> query ('SET CHARACTER_SET utf8_unicode_ci');
	
	$zapytanieouzytkownika = @$polaczeniezbaza->query(sprintf("SELECT * FROM logowanie WHERE pesel='$wybor'"));
		$wynik =  $zapytanieouzytkownika->fetch_assoc();
										
										$_SESSION['imie_pok'] = $wynik['imie'];
										$_SESSION['nazwisko_pok'] = $wynik['nazwisko'];
										$_SESSION['pesel'] = $wynik['pesel'];
										$_SESSION['matematyka'] = $wynik['matematyka'];
										$_SESSION['jpolski'] = $wynik['jpolski'];
										$_SESSION['jangielski'] = $wynik['jangielski'];
										$_SESSION['jniemiecki'] = $wynik['jniemiecki'];
										$_SESSION['informatyka'] = $wynik['informatyka'];
										
	header('location: e-dziennik.php');
?>
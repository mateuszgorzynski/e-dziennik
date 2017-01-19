
<?php
	session_start();
	
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('location: index.php');
		exit();
		}
		
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pl">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style/style_logowanie.css" type="text/css" />
<?php echo "<title>Witaj ".$_SESSION['imie']." w twoim E-Dzienniku</title>"; ?>

</head>

<body>



<div id="lewa">
<div id="container">
<?php
if($_SESSION['nauczyciel']==1)
{

echo "<div class='pokaz'>Imię: ".$_SESSION['imie']."</div><br />";
echo "<div class='pokaz'>Nazwisko ".$_SESSION['nazwisko']."</div><br />";


		if(isset($_SESSION['dodano']))
		{
			echo $_SESSION['dodano'];
			echo"<br /><br />"; 
			unset($_SESSION['dodano']);
		}
	
		if(isset($_SESSION['blad']))
		{
			echo $_SESSION['blad'];
			echo"<br /><br />"; 
			unset($_SESSION['blad']);
		}
	
		
	?>
<form action="dodawanieocen.php" method="post">

		<input type="text" name="peselucznia" placeholder="Pesel Ucznia" onfocus="this.placeholder=' '" onBlur="this.placeholder='Pesel Ucznia'">
		<br />
		
		<input type="text" name="matematyka" placeholder="Matematyka" onfocus="this.placeholder=' '" onBlur="this.placeholder='Matematyka'">
        <br />
		<input type="text" name="jpolski" placeholder="J. Polski" onfocus="this.placeholder=' '" onBlur="this.placeholder='J. Polski'">
        <br />
		<input type="text" name="jangielski" placeholder="J. Angielski" onfocus="this.placeholder=' '" onBlur="this.placeholder='j. Angielski'">
        <br />
		<input type="text" name="informatyka" placeholder="Informatyka" onfocus="this.placeholder=' '" onBlur="this.placeholder='Informatyka'">
        <br />
		<input type="text" name="jniemiecki" placeholder="J. Niemiecki" onfocus="this.placeholder=' '" onBlur="this.placeholder='j. Niemiecki'">
        <br />

		<input type="submit" value="Zaktualizuj oceny!" />
</form>
</div>
</div>


<div id="prawa">
<div id="container">

<?php

require_once"dane_do_logowania_baza.php";

	$polaczeniezbaza=@new mysqli($adresbazy, $db_login,$db_password, $bazadanych);
	$polaczeniezbaza -> query ('SET NAMES utf8');
	$polaczeniezbaza -> query ('SET CHARACTER_SET utf8_unicode_ci');
$zapytanieouzytkownika = @$polaczeniezbaza->query(sprintf("SELECT * FROM logowanie"));
		$ilewynikow =  $zapytanieouzytkownika->num_rows;
		

		echo '<form method="post"  action="pokazywanie_ocen.php">';
				echo '<select name="nazwa">';
		for($a=1;$a<=$ilewynikow;$a++)
		{
			$zapytanie= @$polaczeniezbaza->query(sprintf("SELECT * FROM logowanie WHERE ID='$a'"));
			$wynik = $zapytanie->fetch_assoc();
			if($wynik['czy_nauczyciel']=='0')
					{
						
						echo '<option vaule="'.$wynik['ID'].'" >';
						echo  $wynik['pesel'];
						echo "</option>";
						
					
					}
		}
				
				echo '</select>';
				echo '<input type="submit" value="POKAZ OCENY!" />';
			echo '</form>';
echo "<br /><br />";
	if(isset($_SESSION['wyswietlanie_ocen']))
	{	
		echo "<div class='pokaz'>Imię ucznia: ".$_SESSION['imie_pok']."</div><br />";
		echo "<div class='pokaz'>Nazwisko ucznia: ".$_SESSION['nazwisko_pok']."</div><br />";
		echo "<div class='pokaz'>Pesel ucznia: ".$_SESSION['pesel']."</div><br />";
		echo "<div class='pokaz'>Język Polski: ".$_SESSION['jpolski']."</div><br />";
		echo "<div class='pokaz'>Matematyka: ".$_SESSION['matematyka']."</div><br />";
		echo "<div class='pokaz'>Język angielski: ".$_SESSION['jangielski']."</div><br />";
		echo "<div class='pokaz'>Informatyka: ".$_SESSION['informatyka']."</div><br />";
		echo "<div class='pokaz'>Język Niemiecki: ".$_SESSION['jniemiecki']."</div><br />";
		
		unset($_SESSION['wyswietlanie_ocen']);

	}

?>

</div>
</div>

<?php
}


else
{
	
echo "<div class='pokaz'>Imię ucznia: ".$_SESSION['imie']."</div><br />";
		echo "<div class='pokaz'>Nazwisko ucznia: ".$_SESSION['nazwisko']."</div><br />";
		echo "<div class='pokaz'>Język Polski: ".$_SESSION['jpolski']."</div><br />";
		echo "<div class='pokaz'>Matematyka: ".$_SESSION['matematyka']."</div><br />";
		echo "<div class='pokaz'>Język angielski: ".$_SESSION['jangielski']."</div><br />";
		echo "<div class='pokaz'>Informatyka: ".$_SESSION['informatyka']."</div><br />";
		echo "<div class='pokaz'>Język Niemiecki: ".$_SESSION['jniemiecki']."</div><br />";
	
	
}	
	?>
	
	
	

<?php
echo '<a href="wylogowanie.php">Wyloguj się!</a></p>';
?>
</body>
</html>
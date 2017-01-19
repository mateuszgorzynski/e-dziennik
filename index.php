<?php

	session_start();
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true))
	{
		header('location: e-dziennik.php');
		exit();
		}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>E-dziennik</title>
<link rel="stylesheet" href="style/style_logowanie.css" type="text/css" />
<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
<div id="lewa">
<div id="container">
	<form action="logowanie.php" method="post">
    	
        <input type="email" name="email" placeholder="E-mail" onfocus="this.placeholder=' '" onBlur="this.placeholder='E-mail'">
        <br />
   
      <input type="password" name="haslo" placeholder="Hasło dostępu" onfocus="this.placeholder=' '" onBlur="this.placeholder='Hasło dostępu'">
        
        <br /><br />
        <?php
		if(isset($_SESSION['blad']))
		{
			echo $_SESSION['blad'];
			unset($_SESSION['blad']);
			echo"<br /><br />"; 
		}
	
		
		?>
        
        
        <input type="submit" value="Zaloguj sie!" />
        
</form>

</div>
        
</div>
<div id="prawa">
<div id="container">
<?php
if((isset($_SESSION['udanarejestracja'])))
	{
		echo $_SESSION['udanarejestracja'];
		unset($_SESSION['udanarejestracja']);
		echo"<br /><br />"; 
		
		}
?>	
<form action="rejestracja.php" method="post">
		Imię: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_imie']))
			{
				echo $_SESSION['fr_imie'];
				unset($_SESSION['fr_imie']);
			}
		?>" name="imie" /><br />
		<?php
			if (isset($_SESSION['e_imie']))
			{
				echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
				unset($_SESSION['e_imie']);
			}
		?>
		
		Nazwisko: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_nazwisko']))
			{
				echo $_SESSION['fr_nazwisko'];
				unset($_SESSION['fr_nawisko']);
			}
		?>" name="nazwisko" /><br />
		<?php
			if (isset($_SESSION['e_nazwisko']))
			{
				echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
				unset($_SESSION['e_nazwisko']);
			}
		?>
		
		E-mail: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>" name="email" /><br />
			<?php
            if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}?>
		Twoje hasło: <br /> <input type="password"  value="" name="haslo1" /><br />
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		
		
		Powtórz hasło: <br /> <input type="password" value="" name="haslo2" /><br />
		
		Twoj pesel: <br /> <input type="pesel" value="<?php
			if (isset($_SESSION['fr_pesel']))
			{
				echo $_SESSION['fr_pesel'];
				unset($_SESSION['fr_pesel']);
			}
		?>" name="pesel" /><br />
			<?php
			if (isset($_SESSION['e_pesel']))
			{
				echo '<div class="error">'.$_SESSION['e_pesel'].'</div>';
				unset($_SESSION['e_pesel']);
			}
			?>	
		Wpisz specjalny kod(jeśli takowy został dostarczony): <br /> <input type="text" value="" name="specjalnykod" /><br />
		<br />
        <br />
		<label>
			<input type="checkbox" name="regulamin" /> Akceptuję regulamin
		</label>
		
		<?php
			if (isset($_SESSION['e_regulamin']))
			{
				echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
				unset($_SESSION['e_regulamin']);
			}
		?>	
		<br/>
		
		<input type="submit" value="Zarejestruj się" />
		
	</form>

</div>
	
	</div>
</div>
</body>
</html>
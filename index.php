<?php
	session_start();
	if (isset($_SESSION['loggedin'])){
		header('Location: strona.php');
	}
	if(isset($_SESSION['czekaj'])){
		echo "Czekaj 1 minutę<br>";
		$nuile =  $_SESSION['minuta'];
		echo $nuile;
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Bagniewska</title>
	</head>
	<BODY>
		Formularz logowania<br>
		<form method="post" action="logowanie.php">
			Login:<input type="text" name="user" maxlength="20" size="20" required><br>
			Hasło:<input type="password" name="pass" maxlength="20" size="20" required><br>
			<input type="submit" name="zaloguj" value="Zaloguj"/>
		</form><br><br>

		Formularz rejestracji<br>
		<form method="post" action="rejestracja.php">
			Login:<input type="text" name="ruser" maxlength="20" size="20" required><br>
			Hasło:<input type="password" name="rpass" maxlength="20" size="20" required><br>
			Powtórz hasło:<input type="password" name="rpass2" maxlength="20" size="20" required><br>
			<input type="submit" name="zarejestruj" value="Zarejestruj"/>
		</form>
	</BODY>
</HTML>
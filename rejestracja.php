<?php
	session_start();

	if (isset($_SESSION['loggedin'])){
		header('Location: strona.php');
	}
	
	$login = $_POST['ruser'];
	$haslo = $_POST['rpass'];
	$haslo2 = $_POST['rpass2'];
	
	$dbhost="mysql01.abagniewska.beep.pl"; $dbuser="abagniewska7"; $dbpassword="1qaz@WSX"; $dbname="db-7";

	$polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
	if(!$polaczenie) { 
		echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); 
	} 
	
	$result = mysqli_query($polaczenie, "SELECT * FROM `uzytkownicy` WHERE `login`='$login'");
	$ile = mysqli_num_rows($result);
	
	if(!preg_match('/^[0-9|a-z|A-Z]{1,20}$/', $_POST['ruser'])){
		echo "Login może składać się tylko z liter alfabetu angielskiego i cyfr";
	}else{
		if ($ile>0){
			echo "Podany login znajduje się już w bazie. Spróbuj ponownie.";
		}else{
			if($haslo!=$haslo2){
				echo "Wprowadzane hasła są różne. Spóbuj ponownie.";
			}else{
				mysqli_query($polaczenie, "INSERT INTO `uzytkownicy` (`login`, `haslo`) VALUES ('$login', '$haslo')") or die ("Błąd zapytania do bazy result: $dbname");
			
				$sciezka = '/home/virtualki/214586/z7/'.$login;
			
				$folder = mkdir($sciezka, 0777);
				$_SESSION['sciezka'] = $sciezka;
				header('Location: index.php');
			}
		}
	}	
?>
<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Bagniewska</title>
	</HEAD>
	<BODY>
	<?php
		$login = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8");             
		$haslo = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8");             
		$dbhost="mysql01.abagniewska.beep.pl"; $dbuser="abagniewska7"; $dbpassword="1qaz@WSX"; $dbname="db-7";
		$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
		$data = date("Y-m-d H:i:s");
		if(!$link){ 
			echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); 
		}        
		mysqli_query($link, "SET NAMES 'utf8'");    
		$result = mysqli_query($link, "SELECT * FROM `uzytkownicy` WHERE `login`='$login'"); 
		$rekord = mysqli_fetch_array($result);
		
		$result2 = mysqli_query($link, "SELECT * FROM `logi` WHERE `login`='$login'");
		$rekord2 = mysqli_fetch_array($result2);
		
		$result3 = mysqli_query($link, "SELECT `datagodzinan` FROM `logi` WHERE `login` = '$login'");
		$rekord3 = mysqli_fetch_array($result3);
		
		if(!$rekord){
			mysqli_close($link);
			echo "Brak użytkownika o takim loginie !";
		}else{    
			$czas_minuta = strtotime($data);
			$czas_minuta2 = idate('i', $czas_minuta);
			
			$datetry = $rekord2['datagodzinan'];
			$datetry2 = strtotime($datetry);
			$datetry3 = idate('i', $datetry2);
			
			$roznica = $datetry3 - $czas_minuta2;
			
			$nuile1 = $rekord2['probanieudana'];
			$nuile = (int)$nuile1;
			
			if((!$rekord3) || (($result3) && ($nuile < 3))){	
			
				if($rekord['haslo']==$haslo){                      
					if(!$rekord2){
						$ile = 1;
						$zero=0;
						mysqli_query($link, "INSERT INTO `logi` (`login`, `datagodzinau`, `probaudana`, `probanieudana`) VALUES ('$login', '$data', '$ile', '$zero')") or die ("logi udane");
							
					}else{
						$zero=0;
						$ile = $rekord2['probaudana'] + 1;
						mysqli_query($link, "UPDATE `logi` SET `datagodzinau`='$data' WHERE `login`='$login'") or die ("logi udane");
						mysqli_query($link, "UPDATE `logi` SET `probaudana`='$ile' WHERE `login`='$login'") or die ("logi udane");				
						mysqli_query($link, "UPDATE `logi` SET `probanieudana`='$zero' WHERE `login`='$login'") or die ("logi udane");				
					}
	
					$_SESSION ['loggedin'] = true;
					$_SESSION['login'] = $login;
						
					header('Location: strona.php');
						
						
				}else{
					$_SESSION['notloggedin'] = true;
					if(!$rekord2){
						$ile = 1;
						mysqli_query($link, "INSERT INTO `logi` (`login`, `datagodzinan`, `probanieudana`) VALUES ('$login', '$data', '$ile')") or die ("logi nieudane");
							
						mysqli_close($link);
							
					}else{
						$ile = $rekord2['probanieudana'] +1;
						mysqli_query($link, "UPDATE `logi` SET `datagodzinan`='$data' WHERE `login`='$login'") or die ("logi nieudane");
						mysqli_query($link, "UPDATE `logi` SET `probanieudana`='$ile' WHERE `login`='$login'") or die ("logi nieudane");
						if($ile == 3){
							$_SESSION['bladlogowania'] = true;
						}
					}
					header('Location: index.php');
				}
			}else{
				if(($roznica == 0) && ($nuile == 3)){
					$_SESSION['czekaj'] = true;
					$_SESSION['minuta'] = $nuile;
					header('Location: index.php'); 
					}
			}
			if(($roznica != 0) && ($nuile == 3)){
				if($rekord['haslo']==$haslo){                        
					if(!$rekord2){
						$ile = 1;
						$zero=0;
						mysqli_query($link, "INSERT INTO `logi` (`login`, `datagodzinau`, `probaudana`, `probanieudana`) VALUES ('$login', '$data', '$ile', '$zero')") or die ("logi udane");
								
					}else{
						$zero=0;
						$ile = $rekord2['probaudana'] + 1;
						mysqli_query($link, "UPDATE `logi` SET `datagodzinau`='$data' WHERE `login`='$login'") or die ("logi udane");
						mysqli_query($link, "UPDATE `logi` SET `probaudana`='$ile' WHERE `login`='$login'") or die ("logi udane");				
						mysqli_query($link, "UPDATE `logi` SET `probanieudana`='$zero' WHERE `login`='$login'") or die ("logi udane");				
					}
							
					$_SESSION ['loggedin'] = true;
					$_SESSION['login'] = $login;						
					header('Location: strona.php');
									
				}else{
					$_SESSION['notloggedin'] = true;
					if(!$rekord2){
						$ile = 1;
						mysqli_query($link, "INSERT INTO `logi` (`login`, `datagodzinan`, `probanieudana`) VALUES ('$login', '$data', '$ile')") or die ("logi nieudane");								
						mysqli_close($link);
								
					}else{
						$ile = $rekord2['probanieudana'] +1;
						mysqli_query($link, "UPDATE `logi` SET `datagodzinan`='$data' WHERE `login`='$login'") or die ("logi nieudane");
						mysqli_query($link, "UPDATE `logi` SET `probanieudana`='$ile' WHERE `login`='$login'") or die ("logi nieudane");
						if($ile == 3){
							$_SESSION['bladlogowania'] = true;
						}
					}
					header('Location: index.php');
				}
			}
		}
	?>
	</BODY>
</HTML>

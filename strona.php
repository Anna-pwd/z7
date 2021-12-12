<?php
	session_start();
	if(!isset($_SESSION['loggedin'])){
		header('Location: index.php');
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Bagniewska</title>
	</HEAD>
	<BODY>
		Jesteś zalogowany jako:
		<?php 
			echo $_SESSION['login'];
			$login = $_SESSION['login'];
			$sciezka = $_SESSION['sciezka'];
		?>
		<br>
		<form action="wyloguj.php" name="wyloguj">
			<input type="submit" value="Wyloguj">
		</form><br>
		<?php
			if($_SESSION['bladlogowania']){ 
				$dbhost="mysql01.abagniewska.beep.pl"; $dbuser="abagniewska7"; $dbpassword="1qaz@WSX"; $dbname="db-7";
				$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
				$result = mysqli_query($link, "SELECT * FROM `logi` WHERE `login`='$login'");
				$rekord = mysqli_fetch_array($result);
				$godzina = $rekord['datagodzinan'];
				echo "Ostatnie błędne logowanie: ";
				echo '<span style="color:red;">'.$godzina.'</span>';			
			}

			$root = __DIR__;
					
            function is_in_dir($file, $directory, $recursive = true, $limit = 1000){
                $directory = realpath($directory);
                $parent = realpath($file);
                $i = 0;
                while($parent){
					if($directory == $parent){
						return true;
					}
                    if($parent == dirname($parent) || !$recursive){
						break;
					}
                    $parent = dirname($parent);
                }
                return false;
            }

            $path = "/$login";
            $_SESSION['path'] = $path;
            if(isset($_GET['file'])){
                $path = $_GET['file'];
                if (!is_in_dir($_GET['file'], $root)){
                    $path = null;
                }else{
					echo '<div>Aktualny katalog: '.$path.'</div>';
                    $path = '/'.$path;
                    $_SESSION['path'] = $path;
                }
            }else{
                echo '<div>Aktualny katalog: '.$path.'</div>';
            }
            if(is_file($root.$path)){
                readfile($root.$path);
                return;
            }
            if ($path == '/'.$login){
            }else{
                echo "</br>";
                echo '<a href="?file='.urlencode(substr(dirname($root.$path), strlen($root) + 1)).'"><img src="updir.png" width="30" height="30"></a></br>';
                foreach (glob($root.$path.'/*') as $file) {
                    $file = realpath($file);
                    $link = substr($file, strlen($root) + 1);
                }
            }
            if($path){
                foreach (glob($root.$path.'/*') as $file){
                    $file = realpath($file);
                    $link = substr($file, strlen($root) + 1);
                    $name = basename($file);
                    echo "</br>";
                    echo '<a href="?file='.urlencode($link).'">'.basename($file).'</a> <a href="rmdir.php?name='.$name.'&path='.$path.'"></a> &emsp;';
                    if(is_file($link)){   
                        echo '<a href="'.$link.'" download>Pobierz</a></br>';
                    }else{    
                    }
                }
            }
					
			$_SESSION['root'] = $root;
		?>
		<br>
		Wybierz plik do przesłania: 
		<form action="upload.php" method="post" enctype="multipart/form-data"> 
			<input type="file" name="fileToUpload" id="fileToUpload"> 
			<!--input type="submit" value="Prześlij" name="submit"> -->
			<button type="submit"><img src="upload.png" width="20" height="20"></button>
		</form>
		
		<br>		
		Utwórz nowy katalog:
		<form method="post" action="nowy.php" name="nowy">
			<input type="text" name="nowykatalog">
			<input type="submit" value="Utwórz">
		</form>
	</body>
</html>
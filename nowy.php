<?php
	session_start();
	$root = $_SESSION['root'];
	$login = $_SESSION['login'];
	$path = $_SESSION['path'];
	$nazwa = $_POST['nowykatalog'];
	$sciezka = $root.'/'.$path.'/'.$nazwa;
	mkdir($sciezka, 0777);
	header('Location: strona.php')
?>
<?php 
	session_start();
	
	$path = $_SESSION['path']; 
	$root = $_SESSION['root'];
	$target_dir = $root.'/'.$path;
	$target_file = $target_dir . "/". basename($_FILES["fileToUpload"]["name"]); 
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){ 
		echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " uploaded."; 
		header('Location: strona.php');
	}else{ 
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
		} 
		echo "Error uploading file."; 
	} 
	header('Location: strona.php');
?>
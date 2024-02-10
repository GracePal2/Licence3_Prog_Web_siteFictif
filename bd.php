<?php
	function getBD(){
		$bdd = new PDO('mysql:host=localhost;dbname=fruits_paradise;charset=utf8', 'root', '');
		return $bdd;	
	}
?>

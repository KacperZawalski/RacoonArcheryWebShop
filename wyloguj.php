<?php
	session_name("nazwa_sesji");
	session_start();
	unset($_SESSION['zalogowano']);
	unset($_SESSION['koszyk']);
	header("location:index.php");
?>
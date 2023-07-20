 	<?php
	session_name("nazwa_sesji");
	session_start();
	//unset($_SESSION['koszyk']['nazwy,ilosci']);
	?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
<meta charset="utf-8"></meta>
</head>
<body>
<div class="slider">
	<div class="logo"><a href="index.php"><img class="szop" src="szop.png"></img></a></div>
	<div class="shop_name">Raccon Archery </div>
	<ul class="list">
		<li>Łuki</li>
		<li>Strzały</li>
		<li>Cięciwy</li>
		<li>Ochraniacze</li>
		<li>Kołczany</li>
		<li>Akcesoria</li>
	</ul>
	<div class="basket"><a href="<?php print "index.php?m=8"; ?>"><img class="img_basket" src="basket.png"></img></a></div>
	<div class="login"><a href="<?php if (isSet($_SESSION['zalogowano']) && $_SESSION['zalogowano']==1) print 'index.php?m=2'; else print 'index.php?m=1';?>".><img class="img_login" src="login.png"></img></a></div>
	
</div>
<div class="body">
<?php
	if (isSet($_GET['m']))
	{
		if (@!$_SESSION['zalogowano'] && $_GET['m']==1)
		{
			include("logowanie.php");
		}
		
		if (@$_SESSION['zalogowano'] && $_GET['m']==2)
		{
			include("konto.php");
		}
		
		if ($_GET['m']==3)
			include("rejestracja.php");
		if ($_GET['m']==4)
			include("zarejestrowano.php");
		if ($_GET['m']==5)
			include("zalogowano.php");
		if ($_GET['m']==6 && @$_SESSION['zalogowano'])
			include('edycja_konta.php');
		if ($_GET['m']==7 && @$_SESSION['zalogowano'])
			include("zmiana_hasla.php");
		if ($_GET['m']==8)
			include("koszyk.php");
		if ($_GET['m']==9)
			include("zamow.php");
		if ($_GET['m']==10)
			include("podsumowanie.php");
	}
	else if (isSet($_GET['typ']))
		include ('produkt.php');
	else
		include("content.php");

?>
</div>
<div class="footer">Kacper Zawalski</div>
</body>
</html>

	<?php 
	if (false) //wpisać true aby stworzyć nową bazę
	{
		$connect=mysqli_connect("localhost", "root", "");
		if($connect)
		{
			$query="CREATE DATABASE szop";
			mysqli_query($connect, $query);
			mysqli_select_db($connect, "szop");
			$query="CREATE TABLE tbl_dane(
					ID int PRIMARY KEY AUTO_INCREMENT NOT NULL,
					login varchar(32),
					password varchar(32),
					email varchar(32),
					phone_number varchar(12),
					post_code varchar(6),
					city varchar(32),
					street varchar(32),
					house_number int
					)";
		    $pass=crypt("1234", "QWERT");
			mysqli_query($connect, $query);
			$query="INSERT INTO tbl_dane (login,password) VALUES ('szop','".$pass."')";
			mysqli_query($connect, $query); 
		}  
	}
	
?>
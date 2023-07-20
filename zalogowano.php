<html>
	<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	</head>
	<body>
	<div class="zalogowano_div">
		Zalogowano pomyślnie!<br> <a href="index.php"><input type="button" value="Powrót na stronę główną" class="zalogowano_powrot"></a>
	</div>
</body>
</html>
<?php
	$connect=mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "szop");
	
	$query="SELECT * FROM tbl_dane WHERE login='".$_SESSION['login']."'";
	$result=mysqli_query($connect, $query);
	$record=mysqli_fetch_array($result);
	$_SESSION['ID'] = $record['ID'];
?>	
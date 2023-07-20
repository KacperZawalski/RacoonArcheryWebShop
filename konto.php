<?php
	$connect=mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "szop");
	
	$query="SELECT * FROM tbl_dane WHERE ID='".$_SESSION['ID']."'";
	$result=mysqli_query($connect, $query);
	$record=mysqli_fetch_array($result);
?>

<html>
	<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	</head>
	<body>
			<div class="napis_konto">KONTO</div>
		<div class="konto_div">

			<form action="index.php?m=2" method="post">
				<table class="konto_tabela">
					<tr>
						<td>Login</td> 
						<td><div class="pola_konto"><?php print $record['login']; ?></div></td>
					</tr>
					<tr>
						<td>Imie</td>
						<td><div class="pola_konto"><?php print $record['imie']; ?></div></td>
					</tr>
					<tr>
						<td>Nazwisko</td>
						<td><div class="pola_konto"><?php print $record['nazwisko']; ?></div></td>
					</tr>
					<tr>
						<td>E-Mail</td> 
						<td><div class="pola_konto"><?php print $record['email']; ?></div></td>
					</tr>
					<tr>
						<td>Numer telefonu</td>
						<td><div class="pola_konto"><?php print $record['phone_number']; ?></div></td>
					</tr>
					<tr>
						<td>Kod pocztowy</td>
						<td><div class="pola_konto"><?php print $record['post_code']; ?></div></td>
					</tr>
					<tr>
						<td>Miasto</td>
						<td><div class="pola_konto"><?php print $record['city']; ?></div></td>
					</tr>
					<tr>
						<td>Ulica</td>
						<td><div class="pola_konto"><?php print $record['street']; ?></div></td>
					</tr>
					<tr>
						<td>Numer domu</td>
						<td><div class="pola_konto"><?php print $record['house_number']; ?></div></td>
					</tr>
				</table>
			<input type="button" value="Edytuj dane" class="konto_edytuj_dane" onClick="location.href='index.php?m=6';" />
			<input type="button" value="Wyloguj" class="konto_wyloguj" onClick="location.href='wyloguj.php';" />
		</div>
	</body>
</html>

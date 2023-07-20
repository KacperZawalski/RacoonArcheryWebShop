<?php
	if (isSet($_POST['zmiana_button']))
	{
		$connect=mysqli_connect("localhost", "root", "");
		mysqli_select_db($connect, "szop");
		$query="SELECT login, password FROM tbl_dane WHERE login='".$_SESSION['login']."'";
		$result=mysqli_query($connect, $query);
		$record=mysqli_fetch_array($result);
		$crypted_pass=crypt($_POST['old_password'], "QWERT");
		if ($record['password']==$crypted_pass)
		{
			if ($_POST['new_password']==$_POST['repeat_password'])
			{				
				$new_crypted_pass=crypt($_POST['new_password'],"QWERT");
				$query="UPDATE tbl_dane SET password = '".$new_crypted_pass."' WHERE login= '".$_SESSION['login']."'"; 
				mysqli_query($connect, $query);
				$_SESSION['zmieniono']=1;
			}
			else
				$message="Hasła nie pasują do siebie!";
		}
		else
			$message="Podano błędne hasło!";
	}
?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	</head>
	<body> 
	<div class="napis_konto">Zmiana hasła</div>
	<div class="zmiana_hasla">
		
		<form method="post" action="index.php?m=7">
			<table class="zmiana_hasla_tab">
			<tr>
				<td class="zmiana_hasla_podaj">Podaj stare hasło</td>
				<td><input type="password" class="pola_input" name="old_password"></td>
			</tr>
			<tr>
				<td class="zmiana_hasla_podaj">Podaj nowe hasło</td>
				<td><input type="password" class="pola_input" name="new_password"></td>
			</tr>
			<tr>
				<td class="zmiana_hasla_podaj">Powtórz nowe hasło</td>
				<td><input type="password" class="pola_input" name="repeat_password"></td>
			</tr>
			<tr>
				<td class="zmiana_hasla_podaj"><span class="message"><?php if (isSet($message)) print $message; ?></span></td>
				<td><input type="submit" value="Zmień" class="zmiana_hasla_zmien" name="zmiana_button"></td>
			</tr>
			</table>
		</form>
	</div>
</body>
</html>
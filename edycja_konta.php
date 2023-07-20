<?php
	$connect=mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "szop");
	
	$query="SELECT * FROM tbl_dane WHERE ID='".$_SESSION['ID']."'";
	$result=mysqli_query($connect, $query);
	$record=mysqli_fetch_array($result);
	
	
function checkEmail($email) {
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
		return true;
	else 
		return false;
}

function validatetel($tel) {
    $reg = '/^[0-9\+]{8,13}$/';
    return preg_match($reg, $tel);
}

function validatepostcode($plcode) {
	if (preg_match("/^([0-9]{2})(-[0-9]{3})?$/i",$plcode))
		return true;
	else
		return false;
}


	$ok=0;
	if (isSet($_POST['form_button']))
	{
		$connect=mysqli_connect("localhost", "root", "");
		mysqli_select_db($connect, "szop");
		
		//Login
		if (isSet($_POST['login']) && strlen($_POST['login'])>2 && strstr($_POST['login'], " ")==FALSE)
		{
			if ($connect)
			{
				$query="SELECT * FROM tbl_dane WHERE login='".$_POST['login']."' AND ID!= '".$_SESSION['ID']."';";
				$result=mysqli_query($connect, $query);
				if ($result)
				{
					$count=mysqli_num_rows($result);
					if ($count==0)
						$ok=1;
					else
					{
						$message="Istnieje taki uzytkownik w bazie danych! <br> Wybierz inny login."; 
						$ok=0;
					}
				}
			}
		}
		else 
			$message="Login nie moze zawierac spacji ani byc krotszy niz 2 znaki!";
		
		//Email
		if ($ok)
		{
			if (isSet($_POST['email']) && checkEmail($_POST['email']))
			{
				$connect=mysqli_connect("localhost", "root", "");
				if ($connect)
				{
					$query="SELECT * FROM tbl_dane WHERE email='".$_POST['email']."' AND ID!= '".$_SESSION['ID']."';";
					mysqli_select_db($connect, "szop");
					$result=mysqli_query($connect, $query);
					if ($result)
					{
						$count=mysqli_num_rows($result);
						if ($count==0)
							$ok=1;
						else
						{
							$message='Taki mail jest juz zalogowany';
							$ok=0;
						}	
					}
				}
			}
			else
			{
				$message='Wprowadz poprawny adres email';
				$ok=0;
			}
		}

		//Numer telefonu
		if ($ok)
		{
			if (isSet($_POST['phone_number']) && validatetel($_POST['phone_number']))
			{
				$connect=mysqli_connect("localhost", "root", "");
				if ($connect)
				{
					$query="SELECT * FROM tbl_dane WHERE phone_number='".$_POST['phone_number']."' AND ID!= '".$_SESSION['ID']."';";
					mysqli_select_db($connect, "szop");
					$result=mysqli_query($connect, $query);
					if ($result)
					{
						$count=mysqli_num_rows($result);
						if ($count==0)
							$ok=1;
						else
						{
							$message='Taki numer telefonu jest juz zarejestrowany.';
							$ok=0;
						}	
					}
				}
			}
			else
			{
				$message='Wprowadz poprawny numer telefonu';
				$ok=0;
			}
		}
		
		//Kod pocztowy 
		if ($ok)
			if (isSet($_POST['post_code']) && validatepostcode($_POST['post_code']))
				{
					$ok=1;
				}
				else
				{
					$message="Wprowadz poprawny kod pocztowy!<br>format xx-xxx";
					$ok=0;
				}	
		//Reszta
		if ($ok)
		{
			if (isSet($_POST['city']) &&  strlen($_POST['city'])>2)
			{
				$ok=1;
			}
			else
			{
				$ok=0;
				$message="Podaj nazwe miasta!";
			}
		}
		
		if ($ok)
		{
			if (isSet($_POST['street']) &&  strlen($_POST['street'])>2)
			{
				$ok=1;
			}
			else
			{
				$ok=0;
				$message="Podaj nazwe ulicy!";
			}
		}
	
		if ($ok)
		{
			if (isSet($_POST['house_number']) &&  strlen($_POST['house_number'])>=1)
			{
				$ok=1;
			}
			else
			{
				$ok=0;
				$message="Podaj numer domu!";
			}
		}
			//Wrzucenie danych do bazy
		if ($ok)
		{
			$connect=mysqli_connect("localhost", "root", "");
			mysqli_select_db($connect, "szop");
			if ($connect)
			{
				$query="UPDATE tbl_dane SET login = '".$_POST['login']."', email = '".$_POST['email']."',
				phone_number = '".$_POST['phone_number']."', 
				post_code = '".$_POST['post_code']."',
				imie = '".$_POST['imie']."',
				nazwisko = '".$_POST['nazwisko']."',
				city = '".$_POST['city']."', street = '".$_POST['street']."',
				house_number = '".$_POST['house_number']."'
				WHERE ID = '".$record['ID']."';";
				mysqli_query($connect, $query);
				header("location:index.php?m=2");
			}
		}
	}

?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	</head>
	<body>
			<div class="napis_konto">Edycja Konta</div>
		<div class="konto_div edycja_konta">

			<form action="index.php?m=6" method="post">
				<table class="konto_tabela">
				<tr>
					<td>Login</td> 
					<td><input type="edit" name="login" value="<?php print $record['login']; ?>" class="pola_input"></td>
				</tr>
				<tr>
					<td>Imie</td> 
					<td><input type="edit" name="imie" value="<?php print $record['imie']; ?>" class="pola_input"></td>
				</tr>
				<tr>
					<td>Nazwisko</td> 
					<td><input type="edit" name="nazwisko" value="<?php print $record['nazwisko']; ?>" class="pola_input"></td>
				</tr>
				<tr>
					<td>E-Mail</td> 
					<td><input type="edit" name="email" value="<?php print $record['email']; ?>" class="pola_input"></td>
				</tr>
				<tr>
					<td>Numer telefonu</td>
					<td><input type="edit" name="phone_number" value="<?php print $record['phone_number']; ?>" class="pola_input"></td>
				</tr>
				<tr>
					<td>Kod pocztowy</td>
					<td><input type="edit" name="post_code" value="<?php print $record['post_code']; ?>" class="pola_input"></td>
				</tr>
				<tr>
					<td>Miasto</td>
					<td><input type="edit" name="city" value="<?php print $record['city']; ?>" class="pola_input"></td>
				</tr>
				<tr>
					<td>Ulica</td>
					<td><input type="edit" name="street" value="<?php print $record['street']; ?>" class="pola_input"></td>
				</tr>
				<tr>
					<td>Numer domu</td>
					<td><input type="edit" name="house_number" value="<?php print $record['house_number']; ?>" class="pola_input"></td>
				</tr>
				<tr>
					<td class="edycja_konta_message_td" colspan=2><span class="edycja_konta_message"><?php if (isSet($message)) print $message;?></span></td><td></td>
				</tr>
				<tr>
					<td><input type="button" value="Zmiana hasła" class="edycja_konta_haslo" onClick="location.href='index.php?m=7';" /></td>
					<td><input type="submit" value="Zapisz" class="edycja_konta_zapisz" name="form_button"></td>
				</tr>
				</table>
			</form>
		</div>
	</body>
</html>

<?php
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
				$query="SELECT * FROM tbl_dane WHERE login='".$_POST['login']."'";
				$result=mysqli_query($connect, $query);
				if ($result)
				{
					$count=mysqli_num_rows($result);
					if ($count==0)
						$ok=1;
					else
					{
						$message="Istnieje taki użytkownik w bazie danych! <br> Wybierz inny login."; 
						$ok=0;
					}
				}
			}
		}
		else 
			$message="Login nie może zawierać spacji ani być krótszy niż 2 znaki!";
		//Imie
		if ($ok)
		{
			if ($_POST['imie']=="")
			{
				$message="Podaj imię!";
				$ok=0;
			}

		}
		//Nazwisko
		if ($ok)
		{
			if ($_POST['nazwisko']=="")
			{
				$message="Podaj Nazwisko!";
				$ok=0;
			}
		}
		//Hasło
		if (strlen($_POST['password'])<5 || strstr($_POST['password']," ")==TRUE)
		{
			$message="Hasło nie powinno być krótsze niż 6 znaków!<br>oraz zawierać spacji!";
			$ok=0;
		}
		else
		{
			$crypted_pass = crypt(@$_POST['password'], "QWERT");
		}
		
		//Email
		if ($ok)
		{
			if (isSet($_POST['email']) && checkEmail($_POST['email']))
			{
				$connect=mysqli_connect("localhost", "root", "");
				if ($connect)
				{
					$query="SELECT * FROM tbl_dane WHERE email='".$_POST['email']."'";
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
				$ok=1;
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
					$message="Wprowadź poprawny kod pocztowy!<br>format xx-xxx";
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
				$message="Podaj nazwę miasta!";
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
				$message="Podaj nazwę ulicy!";
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
				$query="INSERT INTO tbl_dane (login, imie, nazwisko, password, email, phone_number, post_code, city, street, house_number) 
						VALUES ('".$_POST['login']."','".$_POST['imie']."','".$_POST['nazwisko']."','".$crypted_pass."','".$_POST['email']."','".$_POST['phone_number']."','".$_POST['post_code']."',
						'".$_POST['city']."','".$_POST['street']."','".$_POST['house_number']."')";
				mysqli_query($connect, $query);
				header("location:index.php?m=4");
			}
		}
	}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
<meta charset="utf-8"></meta>
</head>
<body>
	<div class="napis_konto">Rejestracja</div>
	<div class="konto_div rejestracja_div">

		<form action="index.php?m=3" method="post" name="rejestracja_form">
			<table class="konto_tabela">
				<tr>
					<td>Login</td> 
					<td><input type="edit" name="login" class="pola_input" value="<?php if (isSet($_POST['login'])) print $_POST['login']; ?>"></td>
				</tr>
				<tr>
					<td>Imie</td> 
					<td><input type="edit" name="imie" class="pola_input" value="<?php if (isSet($_POST['imie'])) print $_POST['imie']; ?>"></td>
				</tr>
				<tr>
					<td>Nazwisko</td> 
					<td><input type="edit" name="nazwisko" class="pola_input" value="<?php if (isSet($_POST['nazwisko'])) print $_POST['nazwisko']; ?>"></td>
				</tr>
				<tr>
					<td>Hasło</td> 
					<td><input type="password" name="password" class="pola_input"></td>
				</tr>
				<tr>
					<td>E-Mail</td> 
					<td><input type="edit" name="email" class="pola_input" value="<?php if (isSet($_POST['email'])) print $_POST['email']; ?>"></td>
				</tr>
				<tr>
					<td>Numer telefonu</td>
					<td><input type="edit" name="phone_number" class="pola_input" value="<?php if (isSet($_POST['phone_number'])) print $_POST['phone_number']; ?>"></td>
				</tr>
				<tr>
					<td>Kod pocztowy</td>
					<td><input type="edit" name="post_code" class="pola_input" value="<?php if (isSet($_POST['post_code'])) print $_POST['post_code']; ?>"></td>
				</tr>
				<tr>
					<td>Miasto</td>
					<td><input type="edit" name="city" class="pola_input" value="<?php if (isSet($_POST['city'])) print $_POST['city']; ?>"></td>
				</tr>
				<tr>
					<td>Ulica</td>
					<td><input type="edit" name="street" class="pola_input" value="<?php if (isSet($_POST['street'])) print $_POST['street']; ?>"></td>
				</tr>
				<tr>
					<td>Numer domu</td>
					<td><input type="edit" name="house_number" class="pola_input" value="<?php if (isSet($_POST['house_number'])) print $_POST['house_number']; ?>"></td>
				</tr>
				<tr>
					<td class="edycja_konta_message_td" colspan=2><span class="logowanie_message"><?php if (isSet($message)) print $message;?></span></td>
					<td></td>
				</tr>
				
			</table>
			<input type="submit" value="Zarejestruj" class="edycja_konta_haslo" name="form_button">
		</form>
	</div>
</body>
</html>




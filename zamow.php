<?php
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
function checkEmail($email) {
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
		return true;
	else 
		return false;
}

if (@$_SESSION['zalogowano']==1)
{
	$connect=mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "szop");	
	
	$query="SELECT * FROM tbl_dane WHERE login='".$_SESSION['login']."'";
	$result=mysqli_query($connect, $query);
	$count=mysqli_num_rows($result);
	$record=mysqli_fetch_array($result);
	$_POST['imie']=$record['imie'];
	$_POST['nazwisko']=$record['nazwisko'];
	$_POST['phone_number']=$record['phone_number'];
	$_POST['email']=$record['email'];
	$_POST['post_code']=$record['post_code'];
	$_POST['city']=$record['city'];
	$_POST['street']=$record['street'];
	$_POST['house_number']=$record['house_number'];
	$ok=1;
}
else
{
	//Imie
	if (@$_POST['imie']=="")
	{
		$message="Podaj imię!";
		$ok=0;
	}
	else
		$ok=1;
	//Nazwisko
	if ($ok)
	{
		if ($_POST['nazwisko']=="")
		{
			$message="Podaj Nazwisko!";
			$ok=0;
		}
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
		if ($_POST['post_code']!="" && !validatepostcode($_POST['post_code']))
			{
				$message="Podaj poprawny kod pocztowy!";
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
}
if ($ok && isSet($_POST['dane_dostawy']))
{
	$_SESSION['imie']=$_POST['imie'];
	$_SESSION['nazwisko']=$_POST['nazwisko'];
	$_SESSION['phone_number']=$_POST['phone_number'];
	$_SESSION['email']=$_POST['email'];
	$_SESSION['city']=$_POST['city'];
	$_SESSION['post_code']=$_POST['post_code'];
	$_SESSION['street']=$_POST['street'];
	$_SESSION['house_number']=$_POST['house_number'];
	$_SESSION['delivery']=$_POST['delivery'];
	header("location:index.php?m=10");
}
?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	</head>
	<body> 
			<div class="zamow_naglowek">Dane do dostawy</div>
	<div class="zamow_div">
		<table class="zamow_table">
			<form class="zamow_form" method="post" action="index.php?m=9">
				<tr>
					<td class="zamow_td"><div class="zamow_dane">Imię</div></td>
					<td class="zamow_td"><input class="zamow_input" type="edit" name="imie" value="<?php if (isSet($_POST['imie'])) print $_POST['imie']; ?>"></td>
				</tr>
				<tr>
					<td class="zamow_td"><div class="zamow_dane">Nazwisko</div></td>
					<td class="zamow_td"><input class="zamow_input" type="edit" name="nazwisko" value="<?php if (isSet($_POST['nazwisko'])) print $_POST['nazwisko']; ?>"></td>
				</tr>
				<tr>
					<td class="zamow_td"><div class="zamow_dane">Numer telefonu</div></td>
					<td class="zamow_td"><input class="zamow_input" type="edit" name="phone_number" value="<?php if (isSet($_POST['phone_number'])) print $_POST['phone_number']; ?>"></td>
				</tr>
				<tr>
					<td class="zamow_td"><div class="zamow_dane">E-mail</div></td>
					<td class="zamow_td"><input class="zamow_input" type="email" name="email" value="<?php if (isSet($_POST['email'])) print $_POST['email']; ?>"></td>
				</tr>
				<tr>
					<td class="zamow_td"><div class="zamow_dane">Miasto</div></td>
					<td class="zamow_td"><input class="zamow_input" type="edit" name="city" value="<?php if (isSet($_POST['city'])) print $_POST['city']; ?>"></td>
				</tr>
				<tr>
					<td class="zamow_td"><div class="zamow_dane">Kod pocztowy</div></td>
					<td class="zamow_td"><input class="zamow_input" type="edit" name="post_code" value="<?php if (isSet($_POST['post_code'])) print $_POST['post_code']; ?>"></td>
				</tr>
				<tr>
					<td class="zamow_td"><div class="zamow_dane">Ulica</div></td>
					<td class="zamow_td"><input class="zamow_input" type="edit" name="street" value="<?php if (isSet($_POST['street'])) print $_POST['street']; ?>"></td>
				</tr>
				<tr>
					<td class="zamow_td"><div class="zamow_dane">Numer domu</div></td>
					<td class="zamow_td"><input class="zamow_input" type="edit" name="house_number" value="<?php if (isSet($_POST['house_number'])) print $_POST['house_number']; ?>"></td>
				</tr>
				<tr>
					<td class="zamow_td"><div class="zamow_dane">Sposób dostawy</div></td>
					<td class="zamow_td"><select class="zamow_input" name="delivery">
						<option class="opcje" value="Kurier DPD 17.99">Kurier DPD 17.99zł</option>
						<option class="opcje" value="Kurier DHL 15.99">Kurier DHL 15.99zł</option>
						<option class="opcje" value="Poczta Polska 19.99">Poczta Polska 19.99zł</option>
						<option class="opcje" value="Master Kurier Exclusive Premium Extra Smart 99.99">Master Kurier Exclusive Premium Extra Smart 99.99zł</option>
					</select></td>
				</tr>
				<tr>
					<td class="zamow_td" colspan=2><div class="zamow_message"><?php if (isSet($message)) print $message; ?></div></td>
					<td></td>
				</tr>
				<tr>
					<td colspan=2 class="zamow_td"><div class="zamow_dane zamow_uwagi">Uwagi do zamówienia i dla kuriera:</div></td>
					<td></td>
				</tr>
				<tr>
					<td colspan=2><textarea class="uwagi" name="warnings" value="<?php if (isSet($_POST['warnings'])) print $_POST['warnings']; ?>"></textarea></td>
				</tr>
				<tr>
					<td><a href="index.php?m=8"><input class="zamow_podsumowanie" type="button" value="Powrót do koszyka"></a></td>
					<td><input class="zamow_podsumowanie zamow_podsumowanie_prawe" type="submit" value="Przejdź do podsumowania" name="dane_dostawy"></td>
				</tr>
			</form>
		</table>
	</div>
</body>
</html>
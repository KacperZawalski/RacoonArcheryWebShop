<?php
//session_name("nazwa_sesji");
//session_start();
if (@!$_SESSION['zalogowano'])
{
?>
	
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
<meta charset="utf-8"></meta>
</head>
<body>
<?php
	$connect=mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "szop");
	if (isSet($_POST['login']))
	{
		$query="select * from tbl_dane where login='".$_POST['login']."'";
		$result=mysqli_query($connect, $query);
		if ($result){
			$count=mysqli_num_rows($result);
				if($count==1){
					$tab=mysqli_fetch_array($result);
					$pass=$tab['password'];
				}
		}
	}
?>

	<div class="logowanie_div">
	<form action="index.php?m=1" method="post" class="logowanie">
		Login<input type="edit" name="login" class="logowanie_login"><br>
		Haslo <input type="password" name="password" class="logowanie_haslo"><br>
		<input type="submit" value="Zaloguj" class="logowanie_button">
		<span class="logowanie_message">
<?php
		
	if (isSet($_POST['password']))
	if(isSet($pass) && crypt($_POST['password'], "QWERT")==$pass)
	{
		$_SESSION['zalogowano']=1;
		header("location:index.php?m=5");
		$_SESSION['login']=$_POST['login'];
	}
	else
	{
		print "<br>Błędne hasło";
	}
?>
		</span>
		<span class="nie_masz"><br>Nie masz konta? <a href="index.php?m=3"> Zarejestruj sie!</a></span>
	</form>
	</div>
<?php 
}
?>
</body>
</html>



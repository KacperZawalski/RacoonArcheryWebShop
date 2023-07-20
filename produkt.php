<?php

if (isSet($_GET['typ']))
{
	$connect=mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "szop");	
	
	$query="SELECT * FROM tbl_produkty WHERE nazwa = '".$_GET['typ']."'";
	$result=mysqli_query($connect, $query);
	$count=mysqli_num_rows($result);
	$record=mysqli_fetch_array($result);
	
	if (isSet($_POST['dodaj_do_koszyka']))
	{	
		$przedmiot['nazwa']=$record['nazwa'];
		$przedmiot['ilosc']=$_POST['ilosc'];
		@$_SESSION['koszyk']['nazwy,ilosci'].= $przedmiot['nazwa'].",".$przedmiot['ilosc'].";";
	}
	
	if (isSet($_POST['dodaj_do_koszyka']))
	{
		?>
			<div class="dodano_do_koszyka">Pomyślnie dodano produkt(y) do koszyka!
				<a href="index.php?m=8"><input type="button" value="Przejdź do realizacji zamówienia!" class="przejdz_do_realizacji"></a><br>
				<a href="index.php?typ=<?php print $record['nazwa'];?>"><input type="button" value="Kontynuuj zakupy" class="kontynuuj_zakupy"></a>
			
			</div>
		<?php
	}
?>
<html>
	<head>
	<meta charset="utf-8"></meta>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	</head>
	<body>
		<div class="o_produkt"><img class="o_zdjecie" src="<?php print $record['zdjecie'];?>"></img></div>
		
		<div class="opis_produktu"><?php print str_replace(".",".<br><br>", $record['opis']);?></div>
		
		<div class="o_nazwa_produktu"><?php print $record['nazwa']."<br>"?> <div class="o_cena_produktu"><?php print $record['cena']." zł brutto";?></div>
			<form method="post" action="index.php?typ=<?php print $record['nazwa']?>">
				<span class="ilosc">Ilość</span><input type="edit" name="ilosc" class="amount" value="1"><br>
				<input type="submit" name="dodaj_do_koszyka" class="dodaj_do_koszyka" value="Dodaj do koszyka">
			</form>
			<?php// print $_SESSION['koszyk']['nazwy,ilosci'];?>
		</div>
	</body>
</html>
<?php
}
else
	header("location:index.php");
?>
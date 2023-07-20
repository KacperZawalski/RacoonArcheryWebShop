<html>
	<head>
	<link rel="stylesheet" type="text/css" href="koszyk_style.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	</head>
	<body>
	
<?php
	$connect=mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "szop");	
	
	$query="SELECT * FROM tbl_produkty";
	$result=mysqli_query($connect, $query);
	$count=mysqli_num_rows($result);
	$record=mysqli_fetch_array($result);
 	if (isSet($_GET['toDel']))
	{
		$calosci=explode(";",$_SESSION['koszyk']['nazwy,ilosci']);
		unset($calosci[$_GET['toDel']]);
		$_SESSION['koszyk']['nazwy,ilosci']=implode(";",$calosci);
		header("location:index.php?m=8");
	} 
	if (!isSet($_SESSION['koszyk']['nazwy,ilosci']) || $_SESSION['koszyk']['nazwy,ilosci']=="" || @sizeof($_SESSION['koszyk']['nazwy,ilosci'])==0)
	{
		?>
			<div class="pusty">
				Koszyk jest pusty
			</div>
		<?php
	}
	else
	{
?>
		<div class="o_basket">
			<table class="koszyk_tabela">
				<tr>
					<td class="naglowek" colspan="2">Produkt</td> <td class="naglowek">Ilość</td> <td class="naglowek">Cena</td> <td class="naglowek"></td></tr>
					<?php
					$razem=0;
						$calosci=explode(";",$_SESSION['koszyk']['nazwy,ilosci']);
						$czesci=explode(",",$calosci[0]);
						$j=0;
						for ($i=0;$i<(sizeof($calosci)-1);$i++)
						{
							$czesci=explode(",",$calosci[$j]);
							$query="SELECT cena, zdjecie FROM tbl_produkty WHERE nazwa='".$czesci[0]."'";
							$result=mysqli_query($connect, $query);
							$record=mysqli_fetch_array($result);
							print "<tr><td>";
							print $czesci[0];//nazwy
							print "</td>"?><td class="koszyk_zdjecie_komorka">
							<img class="koszyk_zdjecie" src="<?php print $record['zdjecie'];?>"> </img><?php
							print "</td>";
							print "<td>";
								print $czesci[1];//ilosci
							print "</td><td>";
								print ($record['cena'] * $czesci[1])."zł";
							?>
							</td><td>
							<a href="index.php?m=8&toDel=<?php print $i; ?>"><input type="button" value="Usuń" class="usun"></a>
							<?php
							print "</td></tr>";
							
							
							$razem+=($record['cena'] * $czesci[1]);
							$j++;
						}
						?><tr><td class="podsumowanie" colspan="2">Razem:</td><td colspan="3" class="podsumowanie"><?php print $razem."zł"; ?></td></tr>
			</table>
		</div>
		
		<a href="index.php?m=9"><input type="button" class="koszyk_dostawa" value="Podaj dane do dostawy"></a>
		
	</body>
</html>
<?php
	$_SESSION['razem']=$razem;
	}
?>
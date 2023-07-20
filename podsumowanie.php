
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="podsumowanie_style.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	</head>
	<body>
			<?php
				$connect=mysqli_connect("localhost", "root", "");
				mysqli_select_db($connect, "szop");	
				$dostawa=explode(" ",$_SESSION['delivery']);
				$dlugosc_dostawy=sizeof($dostawa);

			?>
				<table class="tabela">
						<tr>
							<td class="naglowek">Produkt</td> 
							<td class="naglowek">Ilość</td> 
							<td class="naglowek">Cena</td>
						</tr>
						<?php
							$razem=0;
							$calosci=explode(";",$_SESSION['koszyk']['nazwy,ilosci']);
							$czesci=explode(",",$calosci[0]);
							$j=0;
							for ($i=0;$i<(sizeof($calosci)-1);$i++)
							{
								$czesci=explode(",",$calosci[$j]);
								$query="SELECT cena FROM tbl_produkty WHERE nazwa='".$czesci[0]."'";
								$result=mysqli_query($connect, $query);
								$record=mysqli_fetch_array($result);
								
								print "<tr><td>";
								print $czesci[0];//nazwy
								print "</td>";
								print "<td>";
									print $czesci[1];//ilosci
								print "</td><td>";
									print ($record['cena'] * $czesci[1])."zł";
								print "</td></tr>";
								
								
								$razem+=($record['cena'] * $czesci[1]);
								$j++;
							}
						?>
						<tr>
							<td><?php for ($i=0;$i<$dlugosc_dostawy-1;$i++) print $dostawa[$i]." ";?></td>
							<td>1</td>
							<td><?php print $dostawa[$dlugosc_dostawy-1]."zł"; $razem+=$dostawa[$dlugosc_dostawy-1];?></td>
						</tr>	
						<tr>	
							<td class="podsumowanie" colspan="2">Razem:</td>
							<td colspan="3" class="podsumowanie"><?php print $razem."zł"; ?></td>
						</tr>
				</table>
		<div class="adres">
			<table class="tabela tabela_a">
				<tr>
					<td class="naglowek">Imię</td>
					<td><?php print $_SESSION['imie'];?></td>
				</tr>
				<tr>
					<td class="naglowek">Nazwisko</td>
					<td><?php print $_SESSION['nazwisko'];?></td>
				</tr>
				<tr>
					<td class="naglowek">Numer telefonu</td>
					<td><?php print $_SESSION['phone_number'];?></td>
				</tr>
				<tr>
					<td class="naglowek">E-mail</td>
					<td><?php print $_SESSION['email'];?></td>
				</tr>
				<tr>
					<td class="naglowek">Miasto</td>
					<td><?php print $_SESSION['city'];?></td>
				</tr>
				<tr>
					<td class="naglowek">Kod pocztowy</td>
					<td><?php print $_SESSION['post_code'];?></td>
				</tr>
				<tr>
					<td class="naglowek">Adres</td>
					<td><?php print $_SESSION['street']." ".$_SESSION['house_number'];?></td>
				</tr>
			</table>
			<div><form method="post" action="index.php?m=10"><input name="zamawiam" type="submit" class="zamawiam_place" value="Zamawiam i płacę"></div></form>
			<div><a href="index.php?m=9"><input type="button" class="powrot" value="Edytuj zamowienie"></a></div>
		</div>
	</body>
</html>
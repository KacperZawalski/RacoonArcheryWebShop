<?php
	$connect=mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "szop");	
	
	$query="SELECT * FROM tbl_produkty";
	$result=mysqli_query($connect, $query);
	$count=mysqli_num_rows($result);
	$record=mysqli_fetch_array($result);
?>
<html>
	<head>
	<meta charset="utf-8"></meta>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	</head>
	<body>
	<?php
		for ($i=0;$i<$count;$i++)
		{
			$query="SELECT nazwa, cena, zdjecie FROM tbl_produkty WHERE ID='".($i+1)."'";
			$result=mysqli_query($connect, $query);
			$record=mysqli_fetch_array($result);
		?>
			<a href="index.php?typ=<?php print $record['nazwa']?>"><div class="produkty"><img class="produkty_zdjecia" src="<?php print $record['zdjecie'];?>">
				<div class="produkty_nazwa"><?php print $record['nazwa'];?></div><div class="produkty_cena"><?php print $record['cena'];?>zł</div>
			</div></a>
		<?php
		}
	?>
	</body>
</html>
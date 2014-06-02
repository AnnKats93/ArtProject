<?php

	$con = mysqli_connect("localhost", "root", "anna2008", "ArtDB");
	
	
	$address = substr($_GET["srcImg"], strpos($_GET["srcImg"], "Art"));
	//echo $address;

	$idPainterOfPainting = mysqli_fetch_array($con->query("SELECT IdPainter FROM Painting WHERE Address like \"" . $address . "\""))[0];
	//echo $idPainterOfPainting;
	$idPainter = mysqli_fetch_array($con->query("SELECT Id FROM Artist WHERE Name=\"" . $_GET["painterName"] . "\""))[0];
	//echo $idPainter;
	$rightPainter = mysqli_fetch_array($con->query("SELECT Name FROM Artist WHERE Id=" . $idPainterOfPainting))[0];

	mysqli_close($con);

	if ($idPainterOfPainting == $idPainter)
		echo "Right.";
	else
		echo "Wrong! It is " . $rightPainter . ".";
?>
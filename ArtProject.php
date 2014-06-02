<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UFT-8" />
<title>Guess The Painter</title>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<style type="text/css">
#pictures li {
	float:left;
	height:<?php echo ($max_height + 10); ?>px;
	list-style:none outside;
	width:<?php echo ($max_width + 10); ?>px;
	text-align:center;
}
img {
	border:0;
	outline:none;
}
</style>

<script>
	function choseAnswer(ansId) {
	  
	  	var srcImg = document.getElementById('guessImg').src;
		var painterName = document.getElementById('b' + ansId).innerHTML;
		
	  	var xmlhttp = new XMLHttpRequest();
	  	xmlhttp.open("GET", "CheckPainter.php?srcImg=" + srcImg + "&painterName=" + painterName, true);
	  	xmlhttp.onreadystatechange = function()
	  	{
	  		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	  		{
	  			alert (xmlhttp.responseText);

	  			var right = parseInt(document.getElementById('right').innerHTML);
	  			var all = parseInt(document.getElementById('all').innerHTML) + 1;
	  			if(xmlhttp.responseText.localeCompare("Right.") == 0)
	  				right = right + 1;
  				if(all < 100)
					window.location.href = "http://localhost/ArtProject.php?all=" + all.toString() + "&right=" + right.toString();
				else
				{
					alert ("You guessed " + right + "paintings of " + all + ".");
					window.location.href = "http://localhost/ArtProject.php";
				}
	  		}
	  	}
	  	xmlhttp.send(null);

	}
</script>
</head>
<body>

<?php 
	include "ArtProcessor.php";

	$game = new ArtProcessor();
	$imgAddress = $game->getImage();

	$cntAll = $_GET["all"];
	if($cntAll == null)
		$cntAll = 0;
	$cntRight = $_GET["right"];
	if($cntRight == null)
		$cntRight = 0;
?>

<p style="text-align: center">
	 <?php echo "Guessed <span id=\"right\">" . $cntRight . "</span> of <span id=\"all\">" . $cntAll . "</span> paintings."; ?> 
</p>

<p style="text-align: center">
	<img id="guessImg" src = "<?php echo $imgAddress; ?>" >
</p>
<p style="text-align: center">
	<button id="b0" onclick="choseAnswer(0);"><?php echo $game->paintersNameArr[0] ?></button>
  	<button id="b1" onclick="choseAnswer(1);"><?php echo $game->paintersNameArr[1] ?></button>
  	<button id="b2" onclick="choseAnswer(2);"><?php echo $game->paintersNameArr[2] ?></button>
  	<button id="b3" onclick="choseAnswer(3);"><?php echo $game->paintersNameArr[3] ?></button>
</p>


</body>
</html>

<?php

class ArtProcessor
{
	/*public $counterRight = 0;
	public $counterAll = 0;
	*/

	public $paintersIdArr = array();
	public $paintersNameArr = array();
	public $paintingInfo;

	/*function __construct($all, $right) 
	{
    	$counterAll = $all;
    	$counterRight = $right;
    }*/
		

	function getImage()
	{
		$con = mysqli_connect("localhost", "root", "anna2008", "ArtDB");

		if ($con->connect_error)
    			die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);

		$cntPaintings = mysqli_fetch_array($con->query("SELECT count(*) from Painting"))[0];

		$paintingId = rand(1, $cntPaintings);
		$this->paintingInfo = mysqli_fetch_array($con->query("SELECT * from Painting WHERE Id = ". $paintingId));
		
		$cntArtists = mysqli_fetch_array($con->query("SELECT count(*) from Artist"))[0];

		$this->paintersIdArr[] = $this->paintingInfo['IdPainter'];
		
		for ($i = 1; $i < 4; $i++)
		{
			while(true)
			{
				$nextPainter = rand(1, $cntArtists);
				$equal = 0;
				for($j = 0; $j < $i; $j++)
					if($nextPainter == $this->paintersIdArr[$j])
						$equal = 1;
				if($equal == 0)
					break;
			}
			$this->paintersIdArr[] = $nextPainter;
		}
		shuffle($this->paintersIdArr);

		for ($i = 0; $i < 4; $i++)
		{
			//echo mysqli_fetch_array($con->query("SELECT Name from Artist WHERE Id = ". $this->paintersIdArr[$i]))[0] . "<br>";
			$this->paintersNameArr[] = mysqli_fetch_array($con->query("SELECT Name from Artist WHERE Id = ". $this->paintersIdArr[$i]))[0];
		}

		mysqli_close($con);		

		return $this->paintingInfo['Address'];
	}

	function checkAnswer()
	{
		echo '<p> Checked! </p>';
	}
}


?>

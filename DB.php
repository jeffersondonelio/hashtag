<?php
Class DB{
	function getDBconnect(){
		$conn = mysqli_connect("localhost","root","","hashs") or die("Couldn't connect");
		return $conn;
	}
}
?>

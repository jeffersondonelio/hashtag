<?php

class Friends{
	//-MAIN
	var $db;
	function __construct()
	{
		//-iniciar DB
		//-$this->db = $this->getDBconnect();
	}

	//-DB
	function add($friend="")
	{
		if(!empty($friend)){
			$sql = "INSERT INTO `friends` (`friend`, `time`) VALUES ('".$this->splitFriend($friend)."', CURRENT_TIMESTAMP);";
			$query = mysqli_query($this->db,$sql) or die(mysqli_error());

			return true;
		}else{
			return false;
		}
	}

	function exists($friend="")
	{
		$dados = array();
		if(!empty($friend)){
			$sql = "SELECT * FROM `friends` WHERE hashtag = '".$this->splitFriend($friend)."';";
			//-echo $sql."<br/>";
			$result = mysqli_query($this->db,$sql) or die(mysqli_error());
			$total_rows = mysqli_num_rows($result);
			if($total_rows > 0) {
				while($row = mysqli_fetch_array($result)){
					$dados = $row;
				}
			}
		}
		return $dados;
	}

	//-WEB
	function getFriends($text)
	{
		//Match the hashtags
		preg_match_all('/(^|[^a-z0-9_])@([a-z0-9_]+)/i', $text, $matchedFriends);
		$friendstag = array();

		// For each hashtag, strip all characters but alpha numeric
		if(!empty($matchedFriends[0])) {
			foreach($matchedFriends[0] as $match) {
				$friendstag[] = "@".preg_replace("/[^a-z0-9]+/i", "", $match);
			}
		}
		return $friendstag;
	}

	function convertLinks($friend="")
	{
		$link = '';
		if(!empty($friend)){
			//-foreach($friends as $i => $friend){
				$link = preg_replace(
					array(
						'/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))/', 
						'/(^|[^a-z0-9_])@([a-z0-9_]+)/i'
					), 
					array(
						'<a href="$1" target="_blank">$1</a>', 
						'$1<a href="index.php?friend=$2">@$2</a>'
					), 
				$friend);
			//-}
		}

		return $link;
	}

	function splitFriend($friend="")
	{
		if(!empty($friend)){
			$friend = preg_replace("/\@/","",$friend);
			return strtolower($friend);
		}
	}

	function _debug($dados)
	{
		echo "<pre>";
		print_r($dados);
		echo "</pre>";
	}

}

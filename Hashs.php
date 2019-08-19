<?php
class Hashs{
	//-MAIN
	var $db;
	function __construct()
	{
		//-iniciar DB
		//-$this->db = $this->getDBconnect();
	}

	//-DB
	function add($hash="")
	{
		if(!empty($hash)){
			$sql = "INSERT INTO `hashs` (`hashtag`, `time`) VALUES ('".$this->splitHash($hash)."', CURRENT_TIMESTAMP);";
			$query = mysqli_query($this->db,$sql) or die(mysqli_error());

			return true;
		}else{
			return false;
		}
	}

	function exists($hash="")
	{
		$dados = array();
		if(!empty($hash)){
			$sql = "SELECT * FROM `hashs` WHERE hashtag = '".$this->splitHash($hash)."';";
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
	function getHashtags($text)
	{
		//Match the hashtags
		preg_match_all('/(^|[^a-z0-9_])#([a-z0-9_]+)/i', $text, $matchedHashtags);
		$hashtag = array();

		// For each hashtag, strip all characters but alpha numeric
		if(!empty($matchedHashtags[0])) {
			foreach($matchedHashtags[0] as $match) {
				$hashtag[] = "#".preg_replace("/[^a-z0-9]+/i", "", $match);
			}
		}
		return $hashtag;
	}

	function convertLinks($text='')
	{
		$link = '';
		if(!empty($text)){
			$link = preg_replace(
				array(
					'/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))/',
					'/(^|[^a-z0-9_])#([a-z0-9_]+)/i'
				), 
				array(
					'<a href="$1" target="_blank">$1</a>',
					'$1<a href="index.php?hashtag=$2">#$2</a>'
				), 
			$text);
		}

		return $link;
	}

	function splitHash($hash="")
	{
		if(!empty($hash)){
			$hash = preg_replace("/\#/","",$hash);
			return strtolower($hash);
		}
	}

	function _debug($dados)
	{
		echo "<pre>";
		print_r($dados);
		echo "</pre>";
	}
}



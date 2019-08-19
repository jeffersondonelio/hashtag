<?php

class FOpen{

	function openFile($dir){
		
		$list = array();
		if(file_exists($dir)){
			$bk = fopen($dir, "r") or die("Não foi possivel abrir o arquivo.");
				while ($line = fgets($bk)) {
					$bl = (string)preg_replace("/\n/","",trim($line));
					$list[strtolower(trim($bl))] = $bl;
				}
			fclose($bk);
		}
		return $list;
	}


	function _debug($dados)
	{
		echo "<pre>";
		print_r($dados);
		echo "</pre>";
	}
}

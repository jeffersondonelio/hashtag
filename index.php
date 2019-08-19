<html>
	<head>
		<title>HASHS</title>
	</head>
	<body>

<?php
require_once(__DIR__ . "/Hashs.php");

$dados = ((!empty($_REQUEST)) ? $_REQUEST : "");

if(!empty($dados)){
	$Hashs = new Hashs();
	$Hashs->_debug($dados);
	$text = ((!empty($dados['text'])) ? $dados['text'] : "");

	//verifica se existe texto
	if(!empty($text)){
		//-procura as hashs
		$hashsArray = $Hashs->getHashtags($text);

		//-converte as hashs encontradas em links
		$hashsLinks = $Hashs->convertLinks($hashsArray);

		if(!empty($hashsLinks)){
			foreach($hashsLinks as $i => $hash){
				//-verifica se a hash existe
				$exist = $Hashs->exists($hashsArray[$i]);
				if(empty($exist)){
					//-inere a hash se não existir
					$Hashs->add($hashsArray[$i]);
				}

				//-mostra as hash como link
				echo $hash."<br/>";
			}
		}
	}
}
?>

		<form method="post">
			<textarea id="text" name="text"></textarea><br/>
			<input type="submit" value="Enviar"/>
		</form>
	</body>
</html>


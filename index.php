<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);


	//-DB
	require_once(__DIR__ . "/DB.php");

	//-OPEN FILE
	require_once(__DIR__ . "/FOpen.php");
	$FOpen = new FOpen();

	require_once(__DIR__ . "/Hashs.php");
	$Hashs = new Hashs();

	require_once(__DIR__ . "/Friends.php");
	$Friends = new Friends();

	$dados = ((!empty($_REQUEST)) ? $_REQUEST : "");
?>

<!doctype html>
<html lang="en">
<head>
	
	<!-- Required meta tags -->
	<!-- HTML 4 -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!-- HTML5 -->
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	
	<title>HASHS</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
	
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<!--https://github.com/ichord/At.js-->
	<link rel="stylesheet" href="css/jquery.atwho.css" />
	<script type="text/javascript" src="https://ichord.github.io/Caret.js/src/jquery.caret.js"></script>
	<script type="text/javascript" src="js/jquery.atwho.js"></script>
</head>
<body>
<div class="container-fluid">

	<?php
	if(!empty($dados)){
		$Hashs->_debug($dados);

		//verifica se existe texto
		$text = ((!empty($dados['text'])) ? $dados['text'] : "");
		if(!empty($text)){
			/**GRAVAR OS DADOS EM UM ARQUIVO*/
			file_put_contents("data.txt", print_r($text."\n",true), FILE_APPEND);
		}
	}
	?>

	<form method="post">
		<div class="form-group">
			<label for="exampleFormControlTextarea1">Example textarea</label>
			<textarea class="form-control" id="text" name="text" row="3"></textarea>
		</div>
		<div class="form-group text-right">
			<input class="btn btn-primary" type="submit" value="Enviar"/>
		</div>
	</form>
	
	<?php
		$dataFile = $FOpen->openFile(__DIR__ . "/data.txt");
		if(!empty($dataFile)){

			echo "<div class='row'>";
			foreach($dataFile as $data){
				/* HASHSTAG */
				//-procura as hashs
				$hashsArray = $Hashs->getHashtags($data);

				//-converte as hashs encontradas em links
				$hashsLinks = $Hashs->convertLinks($hashsArray);

				if(!empty($hashsLinks)){
					echo "<div class='col-6'>";
						echo "<h3>HASHS</h3>";
						echo "<ul>";
						foreach($hashsLinks as $i => $hash){
							//-verifica se a hash existe
							//-$exist = $Hashs->exists($hashsArray[$i]);
							if(empty($exist)){
								//-inere a hash se não existir
								//-$Hashs->add($hashsArray[$i]);
							}

							//-mostra as hash como link
							echo "<li>".$hash."</li>";
						}
						echo "</ul>";
					echo "</div>";
				}

				/* FRIENDS*/
				//-procura as hashs
				$friendsArray = $Friends->getFriends($data);

				//-converte as hashs encontradas em links
				$friendsLinks = $Friends->convertLinks($friendsArray);

				if(!empty($friendsLinks)){
					echo "<div class='col-6'>";
						echo "<h3>FRIENDS</h3>";
						echo "<ul>";
							foreach($friendsLinks as $i => $friend){
								//-verifica se a hash existe
								//-$exist = $Friends->exists($friendsArray[$i]);
								if(empty($exist)){
									//-inere a hash se não existir
									//-$Friends->add($friendsArray[$i]);
								}

								//-mostra as hash como link
								echo "<li>".$friend."</li>";
							}
						echo "</ul>";
					echo "</div>";
				}
			}
			echo "</div>";
		}
	?>
</div>

<script>
$(function(){

	var jeremy = decodeURI("J%C3%A9r%C3%A9my") // Jérémy
	var names = ["Jacob","Isabella","Ethan","Emma","Michael","Olivia","Alexander","Sophia","William","Ava","Joshua","Emily","Daniel","Madison","Jayden","Abigail","Noah","Chloe","你好","你你你", jeremy];
	$('#text').atwho({
		at: "@",
		data: names,
		limit: 200,
		callbacks: {
			afterMatchFailed: function(at, el) {
				if (at == '@') {
					tags.push(el.text().trim().slice(1));
					this.model.save(tags);
					this.insert(el.text().trim());
					return false;
				}
			}
		}
	});

	var tags = ["PHP","Facebook"];
	$('#text').atwho({
		at: "#",
		data: tags,
		limit: 200,
		callbacks: {
			afterMatchFailed: function(at, el) {
				if (at == '#') {
					tags.push(el.text().trim().slice(1));
					this.model.save(tags);
					this.insert(el.text().trim());
					return false;
				}
			}
		}
	});


});
</script>

</body>
</html>


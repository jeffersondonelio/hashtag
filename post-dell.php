<?php
require_once __DIR__ . "/../db.php";
require_once __DIR__ . '/../classes/Users.php';
require_once __DIR__ . '/../classes/Posts.php';
require_once __DIR__ . '/../classes/PostUsers.php';
require_once __DIR__ . '/../classes/PostBeers.php';
require_once __DIR__ . '/../classes/PostImages.php';
require_once __DIR__ . '/../classes/BeerPoints.php';

$dados = ((!empty($_REQUEST)) ? $_REQUEST : "");

//-adicionar o post e pegar o post_id gerado
$Posts = new Posts();
$user_id = ((!empty($dados['user_id'])) ? $dados['user_id'] : 0);

if(!empty($dados['post_id'])){
    //-remover os usuarios adicionados
    $PostUsers = new PostUsers();
    $post_users = $PostUsers->getByPostId($dados['post_id']);
    if(!empty($post_users)){        
        if(!$PostUsers->dellByPostId($dados['post_id'])){    
            echo "ERRO POST USER";
            die();
        }    
    }

    //-remover os beers adicionados
    $PostBeers = new PostBeers();
    $post_beers = $PostBeers->getByPostId($dados['post_id']);
    if(!empty($post_beers)){
        if(!$PostBeers->dellByPostId($dados['post_id'])){
            echo "ERRO POST BEER";
            die();
            
        }
    }

    //-remover as images adicionados
    $PostImages = new PostImages();
    $post_images = $PostImages->getByPostId($dados['post_id']);
    if(!empty($post_images)){
        if(!$PostImages->dellByPostId($dados['post_id'])){
            echo "ERRO POST IMAGE";
            die();            
        }
    }

    $BeerPoints = new BeerPoints();
    $post_beer_points = $BeerPoints->getByPostId($dados['post_id']);
    if(!empty($post_beer_points)){
        if(!$BeerPoints->dellByPostId($dados['post_id'])){
            echo "ERRO BEER POINTS";
            die();                        
        }
    } 

    if(!$Posts->dell($dados['post_id'])){
        echo "ERRO POST ";
        die();                    
    }

}


$count = $Posts->getQtdByUserId($user_id);
$count = $count[0]->qtd;

echo json_encode(array("return" => true,"count" => $count));
//-header("Location: /posts/");
?>    

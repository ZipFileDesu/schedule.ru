<?php
    //require_once ('database.php');
    //require_once ("models/articles.php");
    include ('includes/config.php');
    //require_once 'load_twig.php';
    /*$loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader);

    $template = $twig->load('index.html');*/
    $result = $data;
    //print_r($result[0][9]);
    echo $twig->render('index.html',array(
        'users' => $result
    ));
    //$articles = articles_all();
?>
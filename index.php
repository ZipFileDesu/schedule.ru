<?php
    require_once "database.php";
    //require_once ("models/articles.php");
    require_once 'vendor/autoload.php';
    require_once 'load_twig.php';
    /*$loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader);

    $template = $twig->load('index.html');*/
    $result = (new db_handler())->getAllEmployees();
    $template = (new twig())->loadTwig();
    //print_r($result[0][9]);
    echo $template->render(array(
        'users' => $result
    ));
    //$articles = articles_all();
?>
<?php
    require_once ("vendor/autoload.php");
    include ("includes/classes/database.php");
    ob_start();
    session_start();

    $connection = pg_connect("host=localhost port=5432 dbname=fefu user=postgres password=postgres");
    $database = new database($connection);

    $loader = new \Twig\Loader\FilesystemLoader('style/templates');
    $twig = new \Twig\Environment($loader);

    //echo $twig->render('index', ['name' => 'Fabien']);
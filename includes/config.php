<?php
    require_once 'vendor/autoload.php';
    ob_start();
    session_start();

    $db_connection = pg_connect("host=localhost port=5432 dbname=KP25 user=postgres password=postgres")
        or die("Error!" . pg_errormessage(db_connection));

    $loader = new \Twig\Loader\FilesystemLoader('style/templates');
    $twig = new \Twig\Environment($loader);

    $data = [];
    $result = pg_query($db_connection, "SELECT * FROM public.phonebook_person");
    while ($row = pg_fetch_row($result)) {
        $data[] = ['name' => $row[1], 'email' => $row[2]];
    }

    //echo $twig->render('index', ['name' => 'Fabien']);
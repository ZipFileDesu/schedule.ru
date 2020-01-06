<?php
    include("includes/config.php");
    echo $twig->render('index.html', array('loginStatus' => $session));
?>
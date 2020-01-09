<?php
    echo $twig->render('lessons.html', array(
        'subjects' => $database->getAllSubjects(),
        'loginStatus' => $session)
    );
?>

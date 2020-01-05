<?php
    echo $twig->render('tasks.html', array('tasks' => $database->getAllTasks()));
?>
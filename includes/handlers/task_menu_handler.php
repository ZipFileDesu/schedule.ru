<?php
    echo $twig->render('tasks.html', array(
        'tasks' => $database->getAllTasks(),
        'loginStatus' => $session,
        'subjects' => $database->getAllSubjects()
    ));
?>
<?php
    $postStatus = '';
    if(isset($_POST['subject'])){
        $subject = $_POST['subject'];
        $text = $_POST['description'];
        $postStatus = $database->insertTask($subject, $text);
    }
    echo $twig->render('tasks.html', array(
        'tasks' => $database->getAllTasks(),
        'loginStatus' => $session,
        'subjects' => $database->getAllSubjects(),
        'formStatus' => $postStatus
    ));
?>
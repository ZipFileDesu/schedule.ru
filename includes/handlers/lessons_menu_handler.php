<?php
    $poststatus = "";
    if (isset($_POST["subject"])){
        $subject = $_POST["subject"];
        $poststatus = $database->insertSubject($subject);
    }
    echo $twig->render('lessons.html', array(
        'subjects' => $database->getAllSubjects(),
        'loginStatus' => $session,
        'formStatus' => $poststatus,
    ));
?>

<?php
/* TODO: Make handler of post form. Also make in database.php new query on alter table of table marks */
    if(isset($_GET['subject'])) {
        $subjectId = $_GET['subject'];
        echo $twig->render('marks.html', array('subjects' => $database->getAllSubjects(),
            'subject_tasks' => $database->getSubjectTasks($subjectId),
            'students_marks' => $database->getMarks($subjectId), 'subject_selected' => $subjectId,
            'loginStatus' => $session));
    }
    else{
        echo $twig->render('marks.html', array('subjects' => $database->getAllSubjects(),
            'subject_tasks' => $database->getSubjectTasks(1), 'students_marks' => $database->getMarks(1),
            'loginStatus' => $session));
    }
?>
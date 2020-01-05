<?php
    if(isset($_GET['filterSubject'])) {
        $subject_id = $_GET['subject'];
        echo $twig->render('marks.html', array('subjects' => $database->getAllSubjects(),
            'subject_tasks' => $database->getSubjectTasks($subject_id),
            'students_marks' => $database->getMarks($subject_id), 'subject_selected' => $subject_id));
    }
    else{
        echo $twig->render('marks.html', array('subjects' => $database->getAllSubjects(),
            'subject_tasks' => $database->getSubjectTasks(1), 'students_marks' => $database->getMarks(1)));
    }
?>
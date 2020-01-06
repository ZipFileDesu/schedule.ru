<?php
    if(isset($_GET['group'])){
        $group_id = $_GET['group'];
        if($group_id != 0) {
            echo $twig->render('students.html', array('students' => $database->getStudentsByGroup($group_id),
                'groups' => $database->getAllGroups(), 'group_selected' => $group_id, 'loginStatus' => $session));
        }
        else{
            echo $twig->render('students.html', array('students' => $database->getAllStudents(),
                'groups' => $database->getAllGroups(), 'loginStatus' => $session));
        }
    }
    else {
        echo $twig->render('students.html', array('students' => $database->getAllStudents(),
            'groups' => $database->getAllGroups(), 'loginStatus' => $session));
    }
?>
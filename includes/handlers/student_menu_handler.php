<?php
    $postStatus = "";
    if (isset($_POST['firstname']) and isset($_POST['lastname'])) {
        $firstName = $_POST["firstname"];
        $lastName = $_POST["lastname"];
        $middleName = $_POST["middlename"];
        $groupId = $_POST["group"];
        $postStatus = $database->insertStudent($firstName, $lastName, $middleName, $groupId);
    }
    if(isset($_GET['group'])){
        $groupId = $_GET['group'];
        if($groupId != 0) {
            echo $twig->render('students.html', array('students' => $database->getStudentsByGroup($groupId),
                'groups' => $database->getAllGroups(), 'group_selected' => $groupId, 'loginStatus' => $session,
                'formStatus' => $postStatus));
        }
        else{
            echo $twig->render('students.html', array('students' => $database->getAllStudents(),
                'groups' => $database->getAllGroups(), 'loginStatus' => $session, 'formStatus' => $postStatus));
        }
    }
    else {
            echo $twig->render('students.html', array('students' => $database->getAllStudents(),
                'groups' => $database->getAllGroups(), 'loginStatus' => $session, 'formStatus' => $postStatus));
    }
?>
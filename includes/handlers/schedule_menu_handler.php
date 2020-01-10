<?php
    if(isset($_GET['group'])) {
        $groupId = $_GET['group'];
        echo $twig->render('schedule.html', array('schedule' => $database->getSchedule($groupId),
            'date' => $database->getScheduleDate(), 'groups' => $database->getAllGroups(), 'group_selected' => $groupId,
            'loginStatus' => $session));
    }
    else {
        echo $twig->render('schedule.html', array(
            'schedule' => $database->getSchedule(1),
            'date' => $database->getScheduleDate(),
            'groups' => $database->getAllGroups(),
            'professors' => $database->getAllProfessors(),
            'subjects' => $database->getAllSubjects(),
            'pairs' => $database->getAllPairs(),
            'classrooms' => $database->getAllClassRooms(),
            'loginStatus' => $session
        ));
    }
?>
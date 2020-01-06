<?php
    if(isset($_GET['group'])) {
        $group_id = $_GET['group'];
        echo $twig->render('schedule.html', array('schedule' => $database->getSchedule($group_id),
            'date' => $database->getScheduleDate(), 'groups' => $database->getAllGroups(), 'group_selected' => $group_id,
            'loginStatus' => $session));
    }
    else {
        echo $twig->render('schedule.html', array('schedule' => $database->getSchedule(1),
            'date' => $database->getScheduleDate(), 'groups' => $database->getAllGroups(), 'loginStatus' => $session));
    }
?>
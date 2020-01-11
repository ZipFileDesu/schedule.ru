<?php

    $postStatus = "";
    if (isset(
        $_POST['date'], $_POST['pair'], $_POST['subject'],
        $_POST['group'], $_POST['classroom'], $_POST['professor'])) {
        $postStatus = $database->insertIntoSchedule(
            $_POST['date'], $_POST['pair'], $_POST['subject'],
            $_POST['group'], $_POST['classroom'], $_POST['professor']
        );
    }

    $data = array(
        'date' => $database->getScheduleDate(),
        'groups' => $database->getAllGroups(),
        'professors' => $database->getAllProfessors(),
        'subjects' => $database->getAllSubjects(),
        'pairs' => $database->getAllPairs(),
        'classrooms' => $database->getAllClassRooms(),
        'days' => $database->getDays(),
        'schedule' => $database->getSchedule(1),
        'loginStatus' => $session
    );

    if (isset($_GET['group-filter'])) {
        $groupId = $_GET['group-filter'];
        echo $twig->render('schedule.html', array_merge(
            $data,
            array(
                'schedule' => $database->getSchedule($groupId),
                'group_selected' => $groupId,
                'formStatus' => $postStatus
            )
        ));
    }
    else {
        echo $twig->render('schedule.html', array_merge($data, array('formStatus' => $postStatus)));
    }
?>
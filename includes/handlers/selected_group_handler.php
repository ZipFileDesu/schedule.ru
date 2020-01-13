<?php
if(isset($_GET['group_id'])) {
    $groupId = $_GET['group_id'];
    echo $twig->render('selected_group.html', array('selected_group' => $database->getGroupNameById($groupId),
        'students' => $database->getGroupStudentsById($groupId)));
}
?>
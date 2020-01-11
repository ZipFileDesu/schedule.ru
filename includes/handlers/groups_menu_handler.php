<?php
    $poststatus = "";
    if (isset($_POST["group"])){
        $group = $_POST["group"];
        $poststatus = $database->insertGroup($group);
    }
    echo $twig->render('groups.html', array(
        'groups' => $database->getAllGroups(),
        'loginStatus' => $session,
        'formStatus' => $poststatus,
    ));
?>

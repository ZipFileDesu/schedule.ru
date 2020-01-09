<?php
    echo $twig->render('groups.html', array(
        'groups' => $database->getAllGroups(),
        'loginStatus' => $session)
    );
?>

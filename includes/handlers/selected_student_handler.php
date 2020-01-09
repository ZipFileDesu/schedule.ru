<?php
if(isset($_GET['st_id'])) {
    $studentId = $_GET['st_id'];
    echo $twig->render('selected_student.html', array('students' => $database->getStudentById($studentId)));
}
?>
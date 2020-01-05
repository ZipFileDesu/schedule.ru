<?php
if(isset($_GET['st_id'])) {
    $student_id = $_GET['st_id'];
    echo $twig->render('selected_student.html', array('students' => $database->getStudentById($student_id)));
}
?>
<?php
if(isset($_POST['loginButton'])){
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    if($database->login($username, $password)){
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }
    else{
        echo $twig->render('login.html', array('error' => "Ошибка! Неправильный логин или пароль!"));
    }
}
else{
    echo $twig->render('login.html');
}
?>
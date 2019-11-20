<?php
    require_once 'vendor/autoload.php';
    class twig
    {
        public function loadTwig()
        {
            $twig = new Twig_Environment(new Twig_Loader_Filesystem('templates'));
            $template = $twig->load('index.html') or die("Error!");
            return $template;
        }
    }
?>
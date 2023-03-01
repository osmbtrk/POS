<?php
    //start the session
    session_start();
    session_unset();
    session_destroy();
    header('Location: ../accueil.php');
    exit();
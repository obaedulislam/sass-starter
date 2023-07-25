<?php
    /*setcookie('user', "unset", time() + (86400 * 30), "/"); // 86400 = 1 day
    header('location: index.php'); // redirect*/
	
	
	session_start(); // start a session first, else you cannot destroy/unset it
    session_destroy(); // destroy all sessions
    header('location:index.php'); // redirect
?>
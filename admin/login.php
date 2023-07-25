<?php

	include "controllers/coreFunctions/connect.php";
	include "controllers/coreFunctions/coreFunction.php";

	$userid = sterilizeValue($_POST['userid']);
	$password = sterilizeValue($_POST['password']);

	if(empty($userid) || empty($password)){
		echo "User ID and Password field cannot be empty";
	}else{
		if(login("admin", array("username", "password"), array($userid, encryptPassword($password)))){
			session_start();
			$_SESSION["user"] = getValue("admin", "name", "password", encryptPassword($password));
			echo "Access Granted";
		}else{
			echo "Access Denied";
		}
	}

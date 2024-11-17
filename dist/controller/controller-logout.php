<?php
include_once('controller-user-cookies.php');
$userdetails = $userInfoClass->get_userdata();
$userInfoClass->logout($userdetails['email']);

header ("Location: ../login.php");
?>
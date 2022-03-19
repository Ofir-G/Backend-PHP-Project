<?php
require_once('classes/init.php');
global $session;

$session->logout();
header('Location: ../index.php');
?>

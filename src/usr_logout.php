<?php
// if (!ini_get('session.auto_start')) {
// 	session_name('ASN2015FKMYZKANKJP_ID');
// 	session_start();
// }
unset($_SESSION);
session_destroy();
header('Location:?do=usr_login');
?>

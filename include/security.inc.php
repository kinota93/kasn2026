<?php
$secure_login = false;
if (isset($_SESSION['utype'])){
  $secure_login = true;
  $secure_uid   = $_SESSION['uid'];
  $secure_utype = $_SESSION['utype'];
}
$secure_phrase = 1;
$app_curr  = new DateTime();
$app_begin  = new DateTime($conf['app']['begin']);
$app_end    = new DateTime($conf['app']['end']);
if ($app_begin <= $app_curr and $app_curr <= $app_end)
  $secure_phrase = 2;
if ($app_curr > $app_end)
  $secure_phrase = 3;

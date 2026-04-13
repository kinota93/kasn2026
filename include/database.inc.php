<?php
require 'Database.php';
$db = new Database($conf['db']);
if ($db->connect_error()){
  die ("CONNECT ERROR!");

}

<?php
// Error reporting
//error_reporting(0);   // Product environment, reporting nothing
//error_reporting(E_ERROR | E_PARSE); // Avoid E_WARNING, E_NOTICE, etc
//error_reporting(E_ALL); // Development environment, reporting all
date_default_timezone_set("Asia/Tokyo");

if (!ini_get('session.auto_start')) {
	session_name('LAKDLAKLKSDFLFKLDSF');
	session_start();
}

$bs = 'bs33';
include 'conf/config.inc.php';
include 'include/function.inc.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'ent_home';
$noheader = ['usr_check', 'usr_logout'];
if (!in_array($do, $noheader)){
	include "include/{$bs}_page_header.inc.php";
}

include 'include/database.inc.php';
include 'include/security.inc.php';

$actions = $conf['app']['actions'];
if (!array_key_exists($do, $actions)){
	echo tag('h4', '無効な操作です。', array('class'=>'text-danger'));
}else{	
	$security = $actions[$do][1];
	if ($security < 1){
		include('src/' . $do . '.php'); 
	}else if(!$secure_login){
		echo tag('h4', 'この機能はログインしないと利用できません。', array('class'=>'text-danger'));
	}else if ( ($security==2 and $secure_utype!='student') or
		($security==3 and $secure_utype!='manager') or
		($security==4 and $secure_utype!='admin') ){
  		echo tag('h4', 'この機能を利用する権限はありません。', array('class'=>'text-danger'));
  }else{
		include('src/' . $do . '.php');  		
  }
}

include "include/{$bs}_page_footer.inc.php";

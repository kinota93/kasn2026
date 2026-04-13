<?php
function u2s($uid){// uid=>sid, e.g., k14jk001=>14JK001 
	return strtoupper(substr($uid, 1));
}
function s2u($sid){// sid=>uid, e.g., 14JK001=>k14jk001
	return 'k' . strtolower($sid);
}
/**
 * HTML Helper
 **/
function nl(){
	return "\n";
}
function s($content=null){ //single quoted string
	return "'" . $content . "'";
}
function q($content=null){ //double quoted string
	return '"' . $content . '"';
}
function tag($tagname, $content, $options=array()){
	if (is_array($content))
		return _tag($tagname, $content, $options);
	$tag = '<' . $tagname;
	foreach ($options as $name => $value)
		$tag .= ' ' . $name . '=' . q($value);
	return $tag . '>' . $content . '</' . $tagname . '>';
}

function _tag($tagname, $content, $options=array()){
	$tag = '';
	for ($i = 0; $i < count($content); $i++)
		$tag .= tag($tagname, $content[$i], $options);
	return $tag;
}
/**
 * Set operations
 **/
function in($key, $array){
	if (is_array($key))
		return _in($key, $array);
	return array_key_exists($key, $array)||in_array($key, $array);
}
function _in($key, $array){
	for($i=0; $i < count($key); $i++)
		if (!in($key[$i], $array)) return false;
	return true;
}
/**
 * Date and time
 **/
function getJpDate($udate=null){
	if ($udate == null) $udate = date('Y-n-d');
	list($y, $m, $d) = explode('-', $udate, 3) ;
	$week = array("日", "月", "火", "水", "木", "金", "土");
	$wd  =date('w', mktime(0, 0, 0, $m, $d, $y) );
	$yn =  ($y>1988 and $y<2020)? '平成'.($y-1988):$y;
	return $yn.'年'.$m.'月'.$d.'日（'.$week[$wd] . '）';
}

function getJpTime($utime=null) {
	if ($utime==null){
		return date('H時i分s秒') ;
	}
	list($h, $m, $s) = explode(':', $utime, 3) ;
	return $h. '時' . $m . '分'. $s.'秒';
}
/**
 * Network operations
 **/
function getClientIP() {
	if (getenv("HTTP_CLIENT_IP"))
		return getenv("HTTP_CLIENT_IP");
	if(getenv("HTTP_X_FORWARDED_FOR"))
		return getenv("HTTP_X_FORWARDED_FOR");
	if(getenv("REMOTE_ADDR"))
		return getenv("REMOTE_ADDR");
	return "UNKNOWN";
}
function sendmail($from, $to, $subject, $message){
	$subject = mb_encode_mimeheader(mb_convert_encoding($subject, "JIS", "auto"), "JIS");
	$message = mb_convert_encoding($message, "JIS", "auto");
	$headers = "From: " . $from . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "X-Mailer: sendmail.php\r\n";
	$headers .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"";
	$message  = "$message\r\n";
	return mail($to, $subject, $message, $headers);
}
?>

<?php
include 'UserLdap.php';
if (in(array('user','pass'), $_POST))  {
	$user = htmlspecialchars(trim($_POST['user']),ENT_QUOTES);
	$pass = htmlspecialchars(trim($_POST['pass']),ENT_QUOTES);
        $arr = explode('@', $user);
        $domains = ['mail.kyusan-u.ac.jp','ip.kyusan-u.ac.jp','st.kyusan-u.ac.jp'];
	if (count($arr)>1 and in_array($arr[1],$domains)){
          $user = $arr[0];
        }
	$sql = "SELECT * FROM xt_user WHERE uid='{$user}'  AND passwd=md5('$pass')";
	$ldap = new UserLdap();
	$success = $ldap->check($user, $pass);
	if ($success) $sql = "SELECT * FROM xt_user WHERE uid='{$user}'";
	$rs = $db->query($sql);	if (!$rs) die('エラー: ' . $db->error());
	$row = $rs->fetch_assoc();
	if ($row){
		$_SESSION['uid'] = $row['uid'];
		$_SESSION['utype'] 	= $row['utype'];
		$_SESSION['lastname'] 	= $row['lastname'];
		$_SESSION['firstname'] 	= $row['firstname'];
		header('Location:index.php');
	}else{
		echo tag('h3','ログイン失敗！ユーザIDかパスワードが間違っていないか確認してください。',array('class'=>'text-danger'));
  }
}else{
	echo tag('h3','ログイン失敗！ユーザIDかパスワードが間違っていないか確認してください。',array('class'=>'text-danger'));
}

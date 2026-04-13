<?php
if(!$conf['app']['dev'] and $secure_phrase>2){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}
$user = array();
$sql = "SELECT * FROM xt_user WHERE utype='student'";
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
while ($row=$db->fetch_assoc($rs)){
  $user[ $row['uid'] ] = $row['txtpasswd'];
}
echo tag('h2', '以下の学生へアカウント情報を送信しました！', array('class'=>'bg-primary'));
$sql = 'SELECT * FROM xt_student  order by sid';
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
echo '<table class="'.$conf['table'].'">', nl();
$heads = array('No','学籍番号', '氏　　名','所属コース','メールアドレス','送信状態');
echo tag('tr',tag('th',$heads)), nl();
$i = 1;
$mail_subject = '「研究室分け希望調査システム」パスワード案内';
$mail_from = $conf['app']['developer'];
while ($row=$db->fetch_assoc($rs)) {
  $sid = $row['sid'];
  $uid = 'k'. strtolower($row['sid']);
  $email = $uid . $conf['app']['domain'];
  $status = '--';
  if (isset($user[$uid])){
    $txtpasswd = $user[$uid];
    $mail_body = 'ユーザID：'. $uid. '  パスワード：' . $txtpasswd . "\r\n";
    $mail_body.= 'URL: http://jkdb.is.kyusan-u.ac.jp/kasn/';
    $mail_to = $conf['app']['dev'] ? $conf['app']['developer'] : $email; 
    
    $rcd = sendmail($mail_from, $mail_to, $mail_subject, $mail_body);
		if ($rcd) $status = 'OK';
  }
  $course = $row['course']=='a' ? '総合コース' : '応用コース';
  $data = array($i++,$row['sid'], $row['lastname'].' '.$row['firstname'],$course,$email,$status);
  echo tag('tr',tag('td',$data)),nl();
}
echo '</table>';

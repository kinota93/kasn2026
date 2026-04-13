<?php
if(!$conf['app']['dev'] and $secure_phrase>2){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}
$user = array();
$sql = "SELECT * FROM xt_user WHERE utype='student' ORDER BY uid";
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
echo tag('h2', 'アカウント情報を送信しました！', array('class'=>'bg-primary'));
echo '<table class="'.$conf['table'].'">', nl();
$heads = array('No','種別','ユーザID', '氏　　名', 'メールアドレス','送信状態');
echo tag('tr',tag('th',$heads)), nl();
$i = 1;
$mail_subject = '研究室分け希望調査システム初期パスワード';
$mail_from = $conf['app']['developer'];
while ($row=$db->fetch_assoc($rs)) {
  $uid    = $row['uid'];
  $utype  = $row['utype'];
  $name   = $row['lastname'].' '.$row['firstname'];
  $txtpasswd = $row['txtpasswd'];
  $email  = $row['email'];
  $status = '--';
  $mail_body = 'ユーザID：' . $uid . "\r\n";
  $mail_body.= 'パスワード：' . $txtpasswd . "\r\n";
  $mail_body.= 'URL: http://www.is.kyusan-u.ac.jp/kasn/';
  $mail_to = $conf['app']['dev'] ? $conf['app']['developer'] : $email;
  if ($conf['app']['dev'] and $i  > 1) break; //sending one for test 
  $rcd = sendmail($mail_from, $mail_to, $mail_subject, $mail_body);
  if ($rcd) $status = 'OK';  
  $data = array($i++, $utype, $uid, $name, $email, $status);
  echo tag('tr',tag('td',$data)),nl();
}
echo '</table>';

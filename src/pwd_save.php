<?php
$uid = $_POST['uid'];
$oldpass = $_POST['oldpass'];
$newpass1 = $_POST['newpass1'];
$newpass2 = $_POST['newpass2'];
if ($newpass1!=$newpass2){
  echo tag('h3', 'パスワードは一致しません。' , array('class'=>'text-danger'));
}else{
  $sql  = "UPDATE xt_user SET passwd=MD5('$newpass1') WHERE uid='$uid' AND passwd=MD5('$oldpass')";
  $db->query($sql);
  if ($db->affected_rows()>0)
    echo tag('h3', 'パスワードが変更されました。' , array('class'=>'text-success'));
  else
    echo tag('h3', 'パスワード変更が失敗しました。' , array('class'=>'text-danger'));
}

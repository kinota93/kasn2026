<?php
if(!$conf['app']['dev'] and $secure_phrase!=3){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}
$topn = $conf['app']['topn']; // TOP 5
if (isset($_GET['a'])){
  $lbid = $_GET['a'];
  $title = 'GPAによる判定';
  $order = 1;
}elseif (isset($_GET['b'])){
  $lbid = $_GET['b'];
  $order = 2;
  $title = '乱数による判定';
}
$lbname = '';// 研究室名を調べる
$sql="SELECT lbname FROM xt_lab WHERE lbid='$lbid'";
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
$row=$db->fetch_assoc($rs);
if ($row) $lbname = $row['lbname'].'研 - ';

echo tag('h2', $lbname . $title , array('class'=>'bg-primary'));
echo '<div class="form-group">';
echo '<form action="?do=ent_save_" method="post">';
echo '<table class="'.$conf['table'].'">', nl();
$heads = array('学籍番号','氏　名','累積GPA','修得単位','希望順位','判定');
echo tag('tr',tag('th',$heads)), nl();
// 既決定者を調べる
$sql  = "SELECT s.*,a.priority FROM xt_asn a,xt_student s ".
  "WHERE a.sid=s.sid AND decision AND a.lbid='$lbid'";
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
while ($row=$db->fetch_assoc($rs)) {
  $data = array($row['sid'],$row['lastname'].' '.$row['firstname'],$row['gpa'], $row['credit'],$row['priority'],'決定済');
  echo tag('tr',tag('td',$data)),nl();
}
// 未決定者を調べる
$orderby = ($order==1) ? 'gpa DESC' : 'priority,RAND() DESC';
$ranking = ($order==1) ? 'priority=1' : 'priority<='.$topn;
$sql  = 'SELECT s.*,a.priority,RAND() as random ' .
  'FROM xt_asn a, xt_lab b, xt_student s WHERE a.lbid=b.lbid AND a.sid=s.sid AND '.
  'a.sid NOT IN (SELECT sid FROM xt_asn WHERE decision) AND '. $ranking.
  " AND a.lbid='$lbid' ORDER BY " . $orderby;
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
$i = 1;
while ($row=$db->fetch_assoc($rs)) {
  $sid = $row['sid'];
  $sorting = ($order==1) ? $row['priority'] : $row['random'];
  $check = tag('input','',array('type'=>'checkbox','name'=>'sid[]','value'=>$sid,'checked'=>'checked'));
  $data = array($row['sid'],$row['lastname'].' '.$row['firstname'],$row['gpa'], $row['credit'],$row['priority'],$check);
  echo tag('tr',tag('td',$data)),nl();
}
echo '</table>';
echo tag('input','',array('type'=>'hidden','name'=>'lbid','value'=>$lbid));
echo tag('input','',array('class'=>'btn btn-primary','type'=>'submit','value'=>'決定'));
echo '</form>';
echo '</div>';

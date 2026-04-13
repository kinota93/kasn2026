<?php $color=$conf['theme'];?>
<?php
if(!$conf['app']['dev'] and $secure_phrase!=3){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}
$lbid = $_POST['lbid'];
if (!isset($_POST['sid'])){
  echo tag('h3', '処理すべきデータがありません。' , array('class'=>'text-danger'));
}else{
  $students = $_POST['sid'];
  foreach ($students as $sid ){
    $sql  = "UPDATE xt_asn SET decision=TRUE WHERE lbid='$lbid' AND sid='$sid'";
    $db->query($sql);
  }
}
$title = '以下の学生を決定しました！';
// 研究室名を調べる
$lbname = '';
$sql="SELECT lbname FROM xt_lab WHERE lbid='$lbid'";
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
$row=$db->fetch_assoc($rs);
if ($row) $lbname = $row['lbname'].'研に';
echo tag('h2', $lbname . $title , array('class'=>'bg-'.$color));
echo '<table class="'.$conf['table'].'">', nl();
$heads = array('学籍番号','氏　名','累積GPA','修得単位','希望順位','判定');
echo tag('tr',tag('th',$heads)), nl();
// 既決定者を調べる
$sql  = 'SELECT s.sid,s.lastname,s.firstname,s.gpa,s.credit,a.priority FROM xt_asn a,xt_student s '.
  "WHERE a.sid=s.sid AND decision AND a.lbid='$lbid'";
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
while ($row=$db->fetch_assoc($rs)) {
  $data = array($row['sid'],$row['lastname'].' '.$row['firstname'],$row['gpa'], $row['credit'],$row['priority'],'決定済');
  echo tag('tr',tag('td',$data)),nl();
}
echo '</table>';
echo tag('a','続く',array('class'=>'btn btn-primary','href'=>'?do=ent_decide') );

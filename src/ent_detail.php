<?php $color=$conf['theme'];?>
<?php
if(!$conf['app']['dev'] and $secure_phrase<2){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}
echo tag('h2', '登録状況一覧', array('class'=>'bg-'.$color));
$scope = array('a'=>'対象者全員','b'=>'登録済学生','c'=>'未登録学生',);
$curr = isset($_GET['f']) ?  $_GET['f'] : 'a';
$data = '';
foreach ($scope as $f=>$scope){
  $class = ($curr == $f) ? 'active' : '';
  $data .= tag('li', tag('a',$scope,array('href'=>"?do=ent_list&f=".$f)), array('class'=>$class) );
}
echo tag('ul', $data, array('class'=>"nav nav-tabs"));
$entries = array();
$sql = 'SELECT distinct sid FROM xt_asn order by sid';
$rs = $db->query($sql);
if (!$rs) die ('エラー: ' . $db->error());
while ($row=$db->fetch_assoc($rs)){
  $sid = $row['sid'];
  $entries[$sid] = 1;
}
$sql = 'SELECT * FROM xt_student order by sid';
$rs = $db->query($sql);
if (!$rs) die ('エラー: ' . $db->error());
echo '<table class="'.$conf['table'].'">', nl();
$heads = array('No','学籍番号', '氏　　　名','所属コース','累積GPA','取得単位数','登録状況');
echo tag('tr',tag('th',$heads)), nl();
$i = 1;
$yes = tag('span','登録済',array('class'=>'text-success'));
$not = tag('span','未登録',array('class'=>'text-danger'));
while ($row=$db->fetch_assoc($rs)) {
  $sid = $row['sid'];
  $course = $row['course']=='a' ? '総合コース' : '応用コース';
  $status = isset($entries[$sid]) ? $yes : $not ;
  if ($curr=='b' and ! isset($entries[$sid])) continue; // 未登録者をskip
  if ($curr=='c' and   isset($entries[$sid])) continue; // 登録済者をskip
  $data = array($i++,$row['sid'], $row['lastname'].' '.$row['firstname'],$course,$row['gpa'],$row['credit'],$status,);
  echo tag('tr',tag('td',$data)),nl();
}
echo '</table>';

<?php $color=$conf['theme'];?>
<?php
if(!$conf['app']['dev'] and $secure_phrase!=3){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}
$topn = $conf['app']['topn']; // TOP 5
$entries = array();
$sql = 'SELECT lbid,priority,count(*) as people FROM xt_asn ' .
  'WHERE sid NOT IN (SELECT sid FROM xt_asn WHERE decision) GROUP BY lbid,priority';
$rs = $db->query($sql);
if (!$rs)  die ('エラー: ' . $db->error());
while ($row = $rs->fetch_assoc()){
  $lbid = $row['lbid'];
  $rank = $row['priority'];
  $entries[$lbid][$rank]  = $row['people'];
}

echo tag('h2', '研究室配属決定', array('class'=>'bg-'.$color));
echo '<table class="'.$conf['table'].'">';
$heads = array('No.','研究室名','最大定員','最小定員','GPA定員','#1','#2','#3','#4','#5',);
$thead = tag('th', $heads). tag('th','配属決定');
echo tag('tr',$thead), nl();
$i = 1;
$sql = 'SELECT * FROM xt_lab ORDER BY lbseq';
$rs = $db->query($sql);
if (!$rs) die ('エラー: ' . $db->error());
while ($row = $rs->fetch_assoc()){
  $data = tag('td',array( $i++, $row['lbname']. '研',$row['capacity'], $row['capacity']-1, $row['gcapacity'],));
  $lbid = $row['lbid'];
  for ($r=1; $r<=$topn; $r++){
    $count = isset($entries[$lbid][$r]) ? $entries[$lbid][$r] : 0;
    $data .= tag('td',$count) ;
  }
  $btn1 = tag('a','GPA', array('href'=>'?do=ent_decide_&a='.$lbid,'class'=>'btn btn-primary'));
  $btn2 = tag('a','乱数',array('href'=>'?do=ent_decide_&b='.$lbid,'class'=>'btn btn-warning'));
  $data .= tag('td',$btn1.' '.$btn2);
  echo tag('tr',$data), nl();
}
echo "</table>";

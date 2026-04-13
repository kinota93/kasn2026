<?php $color=$conf['theme'];?>
<?php
if(!$conf['app']['dev'] and $secure_phrase!=3){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}
echo tag('h2', '研究室配属', array('class'=>'bg-'.$color));
$sql = "SELECT b.lbname,s.* FROM xt_asn a,xt_lab b,xt_student s ".
  "WHERE a.lbid=b.lbid AND a.sid=s.sid AND decision ORDER BY b.lbseq,s.sid";
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
echo '<table class="'.$conf['table'].'">';
$heads = array('No.','研究室名','学籍番号','氏名');
$thead = tag('th', $heads);
echo tag('tr',$thead), nl();
$i = 1;
while ($row = $rs->fetch_assoc()){
  $data = tag('td',array( $i++, $row['lbname']. '研',$row['sid'], $row['lastname'].' '.$row['firstname'],));
  echo tag('tr',$data), nl();
}
echo "</table>";

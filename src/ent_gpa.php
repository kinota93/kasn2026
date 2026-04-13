<?php $color=$conf['theme'];?>
<?php
echo tag('h2', '成績情報', array('class'=>'bg-'.$color));
$sid = strtoupper(substr($secure_uid,1));
$sql = "SELECT * FROM xt_student WHERE sid='{$sid}'";
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
if ($row = $rs->fetch_assoc()) {
  $sid  = array('学籍番号', $row['sid']);
  $name = array('氏　　名', $row['lastname'].'　'.$row['firstname']);
  $def  = array('a'=>'情報技術コース(総合教育)','b'=>'情報技術コース','c'=>'情報数理コース');
  $course = array('所属コース', $def[ $row['course'] ]);
  $gpa  = array('累積GPA', $row['gpa']);
  $cred = array('修得単位', $row['credit']);
  $rank = array('成績順位', $row['grank']);
 
  echo tag('table',
    tag('tr',tag('td',$sid)) .
    tag('tr',tag('td',$name)).
    tag('tr',tag('td',$course)) .
    tag('tr',tag('td',$gpa)) .
    tag('tr',tag('td',$cred)).
    tag('tr',tag('td',$rank)),
    array('class'=>$conf['table'])
  );
}



<?php $color=$conf['theme'];?>
<?php
if(!$conf['app']['dev'] and $secure_phrase<2){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}

// 各研究室の希望状況を調べる
$topn = $conf['app']['topn']; // TOP 5
$all_entries = array();
$sql = 'SELECT lbid,priority,count(*) as people FROM xt_asn GROUP BY lbid,priority';
$rs = $db->query($sql); if (!$rs)  die ('エラー: ' . $db->error());
while ($row = $rs->fetch_assoc()){
  $lbid = $row['lbid'];
  $rank = $row['priority'];
  $all_entries[$lbid][$rank]  = $row['people'];
}

// ログイン中の学生の希望を調べる
$my_entries = array();
if ($secure_utype=='student'){
  
  $sid = u2s($secure_uid);
  $sql = "SELECT * FROM xt_asn WHERE priority<=5 AND sid='{$sid}'";
  $rs  = $db->query($sql); if (!$rs)  die ('エラー: ' . $db->error());
  while ($row = $rs->fetch_assoc()) {
    $my_entries[$row['priority']] [ $row['lbid'] ] = 1;
  }
  
  // 第1希望研究室における成績順位を調べる（2026～追加）
  $sql = "select * from xt_student where sid='$sid'";
  $rs  = $db->query($sql); if (!$rs)  die ('エラー: ' . $db->error());
  $my_grank = 500;
  if ($row = $rs->fetch_assoc()) {
    $my_grank = $row['grank'];
  }

  $has_entry = false;
  //第1希望者研究室の情報(lbid,lbname,gcapacity)を調べる
  $sql = "select b.lbid, b.lbname, b.gcapacity from xt_asn a, xt_lab b where a.lbid=b.lbid and sid='{$sid}' and a.priority=1";
  $rs  = $db->query($sql); if (!$rs)  die ('エラー: ' . $db->error());
  if ($row = $rs->fetch_assoc()) {
    $has_entry = true;
    $my_lbid= $row['lbid'];
    $my_lbname= $row['lbname'];
    $gcapacity= $row['gcapacity'];
    
    //その研究室の第1希望者数(lab_entries)を調べる
    $sql = "select count(*) as entries from xt_asn where lbid='{$my_lbid}' and priority=1";
    $rs  = $db->query($sql); if (!$rs)  die ('エラー: ' . $db->error());
    $lab_entries = 0 ;
    if ($row = $rs->fetch_assoc()) {
      $lab_entries= $row['entries'];
    }
    //その研究室の第1希望者における自身の成績順位（my_rank）を調べる
    $sql = "select count(*)+1 as my_rank from xt_student 
      where grank<$my_grank and sid in (select sid from xt_asn where lbid='{$my_lbid}' and priority=1)";
    $rs  = $db->query($sql); if (!$rs)  die ('エラー: ' . $db->error());
    $my_rank = 0 ;
    if ($row = $rs->fetch_assoc()) {
      $my_rank= $row['my_rank'];
    }
    $my_status = $my_rank>$gcapacity ? '以外': '以内';
  }
}

echo tag('h2', '研究室希望状況', array('class'=>'bg-'.$color));
echo '<table class="'.$conf['table'].'">';
$heads = array('No.','研究室名','最大定員','GPA定員','第1','第2','第3','第4','第5');
//$thead = tag('th', $heads).tag('th','希望状況(#1～#'.$topn.')', array('colspan'=>$topn));
$thead = tag('th', $heads);
echo tag('tr',$thead), nl();
$i = 1;
$sql = 'SELECT * FROM xt_lab ORDER BY lbseq';
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
while ($row = $rs->fetch_assoc()){
  $lbid = $row['lbid'];
  $data = tag('td',array($i++,$row['lbname'].'研',$row['capacity'],$row['gcapacity'],));
  for ($r=1; $r<=$topn; $r++){
    $my_class = isset($my_entries[$r][$lbid]) ? 'danger' : $color; 
    if (isset($all_entries[$lbid][$r])){
      $attr = array('class'=>'badge progress-bar-' . $my_class);
      $tag = tag('span', $all_entries[$lbid][$r], $attr);
      if (isset($my_entries[$r][$lbid]) and $r == 1){
        $attr = array('class'=>'bg-success','data-toggle'=>"modal", 'data-target'=>"#myModal");
        $icon = '<span class="glyphicon glyphicon-check" aria-hidden="true"></span>';
        $tag .= tag('span', $icon, $attr);   
      }
      $data .= tag('td', $tag);
    }else{
      $data .= tag('td',tag('span',0,array('class'=>'badge')));
    }    
  }
  echo tag('tr',$data), nl();
}
echo "</table>";
if ($secure_utype=='student'){
  echo tag('div',
    tag('span','　　',array('class'=>'badge progress-bar-danger')) . ' ： 本人の希望　'
    . tag('span','　　',array('class'=>'badge progress-bar-'.$color)).' ： その他の希望　' 
    . tag('span','　　',array('class'=>'badge')).' ： 希望者なし' ,
    array('class'=>'text-center')

  ) ;
}
?>
最小定員9人、最大定員10人<br> 
最大定員とする研究室は、第１希望者数の多い研究室を優先して決定する。<br>  
なお、最大定員10人の研究室数は6、9人の研究室数を9とする。

<!-- Button trigger modal 
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>
-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">第1希望研究室における希望順位</h4>
      </div>
      <div class="modal-body">
        あなたの第1希望は<mark><?= $my_lbname?>研究室</mark>で、現時点で第1希望者が<mark><?= $lab_entries?>名</mark>です。
        <br>そのうちあなたの成績順位は<mark>第<?=$my_rank  ?>位</mark>で、<mark>GPA定員<?= $my_status ?></mark>です。
        <br>希望状況が常に変動しているので、上記の情報は最新ではない可能性があります。
        <br>最新の希望状況は、希望状況画面を更新して確認して下さい。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">閉じる</button>

      </div>
    </div>
  </div>
</div>
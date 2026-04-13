<script>
$(function() {
  $( "#sorted li").hover(
    function () {
      $(this).addClass('active');
    },
    function () {
      $(this).removeClass('active');
    });
});
</script>
<?php
if(!$conf['app']['dev'] and $secure_phrase!=2){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}
$secure_uid = $_SESSION['uid'];
$secure_sid = strtoupper(substr($secure_uid,1));
if (isset($_POST['order'])){
  $db->query("BEGIN;");
  for ($i=0; $i<count($_POST['order']); $i++){
    $priority = $i+1;
    $lbid = $_POST['order'][$i];
    $sql  = "REPLACE INTO xt_asn(sid,priority,lbid) VALUES('$secure_sid',$priority,'$lbid');";
    $db->query($sql);
  }
  $db->query("COMMIT;");
}
echo tag('h2', '以下の通り、希望順位が登録されました!', array('class'=>'bg-success'));
$sql = "SELECT b.* FROM xt_asn a, xt_lab b WHERE a.lbid=b.lbid AND a.sid='$secure_sid'";
$rs = $db->query($sql);
if (!$rs) die ('エラー: ' . $db->error());
$item = '';
while ($row = $db->fetch_assoc($rs)){
  $lbid = $row['lbid'];
  $lbname = $row['lbname'].' 研（'. $row['field'] . '） ';
  $item .= tag('li', $lbname, array('class'=>'list-group-item')) . nl();
}
echo tag('ol',$item, array('id'=>'sort','class'=>'list-group'));

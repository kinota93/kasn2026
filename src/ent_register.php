<script>
$(function() {
  $( "#sortable" ).sortable();
  $( "#sortable" ).disableSelection();
  $( "#sortable li").hover( function () {
      $(this).addClass('active');
    },function () {
      $(this).removeClass('active');
    }
  );
});
</script>
<?php $color=$conf['theme'];?>
<?php
if(!$conf['app']['dev'] and $secure_phrase!=2){
  echo tag('h3', '期間外ではこの機能を利用できません。', array('class'=>'text-danger'));
  exit;
}
echo tag('h2', '希望順位', array('class'=>'bg-'.$color));
//echo tag('h2', 'トップ５位まで有効', array('class'=>'bg-warning'));
echo tag('h4', '（ドラッグ＆ドロップで上下に移動きます。トップ５位まで登録されます。)', array('class'=>'text-danger'));
$sid = strtoupper(substr($secure_uid,1));
$sql = "SELECT b.* FROM xt_asn a, xt_lab b WHERE a.lbid=b.lbid AND a.sid='$sid'";
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
if ($db->num_rows($rs)==0){
  $sql = "SELECT * FROM xt_lab ORDER BY lbseq";
  $rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
}
// sortable list (http://jqueryui.com/sortable/)
$data = '';
//$icon = tag('span','', array('class'=>'ui-icon ui-icon-arrowthick-2-n-s'));
$icon = tag('span','', array('class'=>'glyphicon glyphicon-move glyphicon-large'));
while ($row = $db->fetch_assoc($rs)){
  $lbid = $row['lbid'];
  $hidden = tag('input', '', array('type'=>"hidden", 'name'=>'order[]','value'=>$row['lbid'],));
  $lbname = $row['lbname'].' 研（'. $row['field'] . '） ' . $hidden;
  $data .= tag('li', $icon . $lbname, array('class'=>'list-group-item')) . nl();
}
$form = tag('ul',$data, array('id'=>'sortable', 'class'=>'list-group'));
$form .= tag('input','', array('type'=>'submit','value'=>'登録','class'=>'btn btn-primary form-control'));
echo tag('form', $form, array('method'=>'post','action'=>'?do=ent_save'));

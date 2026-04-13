<?php
$color = $conf['theme'];
echo tag('h2', '研究室一覧', array('class'=>'bg-'.$color));
$sql = 'SELECT * FROM xt_lab order by lbseq';
$rs = $db->query($sql); if (!$rs) die ('エラー: ' . $db->error());
echo '<table class="'.$conf['table'].'">', nl();
//$heads = array('No.', '研究室名','専門分野','最大定員','最小定員','GPA定員','紹介ページ',);
$heads = array('No.', '研究室名','専門分野','最大定員','GPA定員','紹介ページ',);//非表示：'最小定員',
echo tag('tr',tag('th',$heads)), nl();
$i = 1;
while ($row=$db->fetch_assoc($rs)) {
	$lbname = $row['lbname']." 研";
	$url  = $row['url'];
        $exlink = ' <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>';
	if (!empty($url)){
	    $exlink = tag('a','外部リンク',array('href'=>$url,'class'=>'btn btn-default btn-sm','target'=>'_blank','data-toggle'=>'tooltip','title'=>"新しいウィンドウで「{$lbname}」のページが開かれます"));
	}
  //$data = array( $i++, $lbname,$row['field'],$row['capacity'], $row['capacity']-1, $row['gcapacity'],$exlink,);
	$data = array( $i++, $lbname,$row['field'],$row['capacity'], $row['gcapacity'],$exlink,);
  echo tag('tr',tag('td',$data)),nl();
}
echo '</table>';
?>
<script>
$(function () {
	$('[data-toggle="tooltip"]').tooltip();
});
</script>

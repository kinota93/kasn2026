<?php $color=$conf['theme'];?>
<?php
if (isset($_POST['confirm'])){
  $sql  = "UPDATE xt_asn SET decision=0 WHERE decision=1";
  $db->query($sql);
  echo tag('h3', '配属案がリセットされました!' , array('class'=>'text-primary'));
}else{
  echo '<form action="?do=ent_reset" method="post">';
  echo tag('h2','配属結果をリセットしてもよろしいですか?',array('class'=>'text-'.$color));
  echo tag('input','',array('type'=>'submit','name'=>'confirm','value'=>' OK ','class'=>'btn btn-primary btn-lg'));
  echo '&nbsp;&nbsp;';
  echo tag('a',' 戻る ',array('href'=>'#','onClick'=>'history.back()','class'=>'btn btn-info btn-lg') );
  echo '</form';
}

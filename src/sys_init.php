<?php
if ( !$secure_login || $secure_utype!='admin' ){
  echo tag('h3', 'この機能を利用する権限がありません。', array('class'=>'text-danger'));
  exit;
}
/**
 * Database initialization from csv files
 **/
$tables = array(// type 1: string (quoted), 0: number
  'xt_student'=> array(
    'sid'=>1,'lastname'=>1,'firstname'=>1,'course'=>1,'gpa'=>0,'credit'=>0,'grank'=>0,
  ),
  'xt_lab'=>array(
    'lbid'=>1,'lbname'=>1,'lbseq'=>0,'lastname'=>1,'firstname'=>1,'field'=>1,'office'=>1,'capacity'=>0,'gcapacity'=>0,'url'=>1, 
  ),
);
if (isset($_POST['csv_files'])){
  foreach($tables as $table=>$fields){
    $file = $_FILES[$table]['tmp_name'];
    $lines = file($file);
    $db->query('BEGIN');
    $db->query('TRUNCATE TABLE ' . $table);
    $keys = array_keys($fields);
    echo '<table class="table table-striped">';
    echo tag('caption',$table);
    echo tag('tr',tag('th',$keys));
    foreach($lines as $line){
      $data = explode(',',$line);
      if (count($data)!=count($keys)) continue;
      $sql = 'INSERT INTO '.$table.'('.implode(',',$keys) .') VALUES (';
      for($i=0; $i<count($keys); $i++){
        $k = $keys[$i];
        $sql.= ($fields[$k]==1) ? s(trim($data[$i])) : trim($data[$i]);
        $sql.= ',';
      }
      $sql = substr($sql,0,-1) . ')';
      $db->query($sql);
      echo tag('tr',tag('td',$data));
    }
    echo '</table>';
    $db->query('COMMIT');
  }
  $db->query('TRUNCATE TABLE xt_asn');
  $db->query("DELETE FROM xt_user WHERE NOT utype='admin'");

  // initialize student accounts
  $sql = "INSERT INTO xt_user(uid,lastname,firstname,txtpasswd,utype,email)
    SELECT CONCAT('k',LOWER(sid)),lastname,firstname,SUBSTR(MD5(sid),4,5),'student',CONCAT('k',LOWER(sid),'@st.kyusan-u.ac.jp') FROM xt_student" ;
  $db->query($sql);
  $db->query("UPDATE xt_user SET passwd=MD5(txtpasswd)");

  // initialize staff accounts
  $t_passwd = $conf['app']['staff_passwd']; // initial staff password
  $sql ="INSERT INTO xt_user(uid,lastname,firstname,txtpasswd,passwd,utype,email)
    SELECT lbid,lastname,firstname,".s($t_passwd).",MD5(".s($t_passwd)."),'staff',CONCAT(lbid,'@is.kyusan-u.ac.jp') FROM xt_lab";
  $db->query($sql);

  // secure manager accounts
  $t_passwd = $conf['app']['manager_passwd']; // initial manager staff password
  $manager = implode("','",$conf['app']['manager']);
  $sql = "UPDATE xt_user SET utype='manager',txtpasswd=".s($t_passwd).",passwd=MD5(".s($t_passwd).") WHERE uid IN (". s($manager) . ")";
  $db->query($sql);
}else{
  echo '<form action="?do=sys_init" method="post" enctype="multipart/form-data">';
  echo tag('input','',array('type'=>'hidden','name'=>'csv_files','value'=>'3'));
  foreach($tables as $table=>$fileds){
    echo '<div class="form-group">';
    $label = tag('span', $table, array('class'=>'label label-default'));
    echo tag('h3',$label);
    echo tag('input', '', array('type'=>'file','name'=>$table,'class'=>'form-control-file'));
    echo '</div>';
  }
  echo '</ul>';
  echo tag('input','',array('class'=>'btn btn-primary','type'=>'submit','value'=>'決定'));
  echo '</form>';
}
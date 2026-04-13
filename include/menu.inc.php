<?php
function menu_item($key){
  global $conf;
  $actions = $conf['app']['actions'];
  if (in($key,$actions)){
    return tag('li',tag('a',$actions[$key][0], array('href'=>'?do='.$key)) );
  }
  return null;
}
function dropdown($title,$items=array()){
  $item = '';
  foreach($items as $action){
    $item.= menu_item($action).nl();
  }
  $title.= tag('span','',array('class'=>"caret"));
  $dropdown =tag('a',$title,array('href'=>"#", 'class'=>'dropdown-toggle', 'data-toggle'=>'dropdown')).nl();
  $dropdown.=tag('ul',$item,array('class'=>'dropdown-menu')).nl();
  return tag('li',$dropdown,array('class'=>'dropdown')).nl();
}
echo menu_item('ent_lab');
if(isset($_SESSION['uid'])){
  $uid = $_SESSION['uid'];
  $utype = $_SESSION['utype'];
  //echo menu_item('ent_lab');
  echo menu_item('ent_summary');
  switch ($utype){
    case 'student':
      $items = array('ent_gpa','ent_register',);
      echo dropdown('学生メニュー', $items); break;
    case 'manager':
      $items = array('ent_decide','ent_result','ent_reset',);
      echo dropdown('教務メニュー', $items); break;
    case 'admin':
      $items = array('sys_init','sys_passwd',);
      echo dropdown('管理者メニュー', $items); break;
    default:            
  }
  echo menu_item('usr_passwd');
  echo menu_item('usr_logout');
}else {
  echo menu_item('usr_login');
}

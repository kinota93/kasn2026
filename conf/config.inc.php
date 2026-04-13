<?php
date_default_timezone_set('Asia/Tokyo');

/*** 
 application-wide settings
***/
$conf['app']['dev'] = false; // true/false: development/deployment environment
$conf['app']['developer']='developer@qmail.jp'; // contact info for developer
$conf['app']['year'] = 2026;
$conf['app']['name']  = '研究室配属希望調査';
$conf['app']['topn']  = 5;
$conf['app']['domain'] = '@st.kyusan-u.ac.jp';
$conf['app']['manager'] = array('taro','jiro');//manager accounts
$conf['app']['manager_passwd'] = 'abcd1234'; // initial manager password
$conf['app']['staff_passwd'] = 'abcd'; // initial staff password

$conf['app']['begin'] = '2026-4-08 10:00';
$conf['app']['end']   = '2026-4-15 18:30';
$conf['app']['schedule'] = array(
  '4月07日（火）10:00～ 研究室配属システム利用開始',
  '4月08日（水）３限目 ガイダンス、研究室訪問、希望調査開始',
  '4月15日（水）３限目 研究室訪問',
  '4月15日（水）18:30 希望調査締切',
  '4月17日（金）配属先発表(掲示) 履修登録(教務課まとめて実施)'
);
// valid actions, otherwise invalid
$conf['app']['actions'] =  array( 
  'ent_home'    =>  ['ホーム',  0],     // 0: ログイン前
  'usr_login'   =>  ['ログイン', 0], 
  'usr_logout'  =>  ['ログアウト',0],    
  'usr_check'   =>  ['認証処理',0],
  'ent_lab'     =>  ['研究室一覧', 0],

  'usr_passwd'  =>  ['パスワード変更', 1], // 1: ログイン中
  'pwd_save'    =>  ['パスワード保存', 1],

  'ent_summary' =>  ['希望状況', 1],  
 
  'ent_gpa'     =>  ['成績確認', 2],    // 2: 学生本人
  'ent_gpa1'     => ['第1希望順位', 2],    // 2: 学生本人
  'ent_register'=>  ['希望登録', 2],  
  'ent_save'    =>  ['希望保存', 2],
  
  'ent_detail'  =>  ['登録状況', 3],    // 3: 教務担当
  'ent_decide'  =>  ['配属処理', 3], 
  'ent_decide_' =>  ['配属処理', 3], 
  'ent_save_'   =>  ['配属保存', 3], 
  'ent_result'  =>  ['配属結果', 3], 
  'ent_reset'   =>  ['やり直し',   3],

  'sys_init'    =>  ['システム初期化', 4], // 4: システム管理者
  'sys_passwd'  =>  ['パスワード送信',  4],  
);


// database connection 
$conf['db'] = array (
/* Deployment Environment  
  'host' => 'localhost',
  'user' => 'root',
  'passwd' => 'fAl98#sk03Q',
  'dbname' => 'kasn2026db',
*/

/* XAMPP x Windows Dev Environment 
  'host' => 'localhost',
  'user' => 'root',
  'passwd' => '',
  'dbname' => 'kasn2026db',
*/

/* LAMPP x Docker Dev Environment*/
  'host' => 'mysql',
  'user' => 'root',
  'passwd' => 'root',
  'dbname' => 'kasn2026db',

);

// styles
$conf['table'] = 'table table-striped table-hover';
$conf['theme'] = 'info';

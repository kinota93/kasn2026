<?php $color=$conf['theme'];?>
<h2 class="bg-<?=$color?>">研究室配属について</h2>
<p>情報科学科では、3年次に情報科学演習I、情報科学演習IIを設けており、情報科学科の各教員がそれぞれ提示するテーマについて調査、分析、討論、実装等を行わせることによって、情報科学の各分野の最新発展とそれまでの学習との関連を学生に理解させることを目的とする。情報科学科各教員に学生を分属させて、各教員が分担して学生を指導する。情報科学演習I、IIの説明及び研究室分けは3年次前期に行う。情報科学演習Iの研究室が、原則として情報科学演習IIおよび4年次の卒業研究の研究室となる。

<h3 class="bg-<?=$color?>">手順</h3>
<ol>
<li>学生は，期限まで第<span class="badge progress-bar-<?=$color?>">１</span>希望から第<span class="badge progress-bar-<?=$color?>">５</span>希望まで希望研究室に順位をつけて希望を提出する
<li>調査終了後、各研究室ごとに第<span class="badge progress-bar-<?=$color?>">１</span>希望の学生のGPA順でGPA定員まで配属を確定する
<li>残り定員までは，第<span class="badge progress-bar-<?=$color?>">１</span>希望の残り学生の中からくじで決める（GPAは無関係）
<li>第<span class="badge progress-bar-<?=$color?>">１</span>希望で配属されなかった学生は，第<span class="badge progress-bar-<?=$color?>">２</span>希望の研究室でくじで配属を決める
<li>以後、第<span class="badge progress-bar-<?=$color?>">５</span>希望まで同じ方法で繰り返し配属していく
</ol>

<h3 class="bg-<?=$color?>">日程</h3>
<ul class="list-group">
<?php
 foreach ($conf['app']['schedule'] as $item){
	 echo '<li class="list-group-item">' . $item . '</li>'; 	
 }
?>	
</ul>

<h3 class="bg-<?=$color?>>">外部リンク</h3>
<ul class="list-group">
<li class="list-group-item">
<a target="_blank" href="https://riko.kyusan-u.ac.jp/joho/">理工学部情報科学科公式サイト</a></li>
<li class="list-group-item">
<a target="_blank" href="http://www-st.is.kyusan-u.ac.jp/">理工学部情報科学科学生用Webサーバ（www-st）</a></li>
</ul>

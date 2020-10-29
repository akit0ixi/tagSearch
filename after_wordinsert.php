<?php
// require('db_connection.php');


// 選択されているカテゴリidの取得
$sql = 'select id from categories where category_name = :cname';
$stmt=$db->prepare($sql);
$stmt->bindValue('cname',h($_POST['after_cate']),PDO::PARAM_STR);
$stmt->execute();
$select_id_af = $stmt->fetchall(); 



// 検索に使った単語をdb追加
$sql = 'insert into words(user_id,word,category_id,date) values(:uid,:word,:category,null)'; 
$stmt=$db->prepare($sql);
$stmt->bindValue('uid',$_SESSION['login_id']??0,PDO::PARAM_INT);
$stmt->bindValue('word',h($_SESSION['word']),PDO::PARAM_STR);
$stmt->bindValue('category',$select_id_af[0]['id'],PDO::PARAM_INT);
$stmt->execute();
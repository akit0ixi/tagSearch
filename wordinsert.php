<?php
// require('db_connection.php');


// 選択されているカテゴリidの取得
if (isset($_SESSION['search_category'])) {

    $sql = 'select id from categories where category_name = :cname';
    $stmt=$db->prepare($sql);
    $stmt->bindValue('cname',h($_SESSION['search_category']),PDO::PARAM_STR);
    $stmt->execute();
    $select_id = $stmt->fetchall(); 
// 検索に使った単語をdb追加


if (mb_strlen($_POST['q']) === 0) {
    $er_wrdinst2 = 1;   
}
try {
    if (isset($er_wrdinst2)) {
        throw new Exception("単語を入力してください");
    }

    $sql = 'insert into words(user_id,word,category_id,date) values(:uid,:word,:category,null)'; 
    $stmt=$db->prepare($sql);
    $stmt->bindValue('uid',$_SESSION['login_id']??0,PDO::PARAM_INT);
    $stmt->bindValue('word',h($_POST['q']),PDO::PARAM_STR);
    $stmt->bindValue('category',$select_id[0]['id'],PDO::PARAM_INT);
    $stmt->execute();

} catch (Exception $e) {
    echo $e->getmessage();
}}
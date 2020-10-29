<?php
// require('db_connection.php');

// ini_set("display_errors",1);
// error_reporting(E_ALL);

// 入力文字に一致するカテゴリの取得
// $input="映画";
$sql = 'select category_name from categories where category_name = :name';
$stmt = $db->prepare($sql);
$stmt->bindValue('name',h($_POST['new_category']),PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchall();
$match_cate = $result;

// 入力されたカテゴリ名がなければ、リストに追加
if(empty($match_cate)){
    // 登録処理
    $input_text = h($_POST['new_category']);
    $params =[
        'id' => null,
        'category_name' => $input_text
    ];
    
    $sql = 'insert into categories (id,category_name) values (null,:new_word)'; 
    $stmt=$db->prepare($sql);
    $stmt->bindValue('new_word',$input_text,PDO::PARAM_STR);
    $stmt->execute();
}

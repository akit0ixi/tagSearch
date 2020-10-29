<?php
session_start();

$_SESSION = array();

require('db_connection.php');

// 特殊文字の処理をする短縮関数定義
function h($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}

// バリデーション
require ('validation.php');
validation($_POST);


// 同一名がいないか確認
$sql = 'select * from users';
$stmt = $db->query($sql);
$result = $stmt->fetchall();
foreach($result as $key => $value){
    if(h($_POST['sign_user_name'])===$value['name']) {
        $setError = 1;
    }
}

try{
    if(isset($setError)){
    throw new Exception("既に使われているユーザー名です");
    }

    // ユーザー登録
    $sql = 'insert into users(id,name,password) values(null,:name,:pass)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue('name',h($_POST['sign_user_name']),PDO::PARAM_STR);
    $stmt->bindValue('pass',$sign_input_pass,PDO::PARAM_STR);
    $stmt->execute();
    
    // login_idをセット
    $sql = 'select id from users where name = :name';
    $stmt = $db->prepare($sql);
    $stmt->bindValue('name',h($_POST['sign_user_name']),PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchall();
    $_SESSION['login_id'] = $result[0]['id'];
    $message = "登録完了しました";
}catch(Exception $e){
    $message = $e->getMessage();
}
    ?>

<html lang="ja">
<head>
<meta charset="utf-8">
<title>サインイン</title>
</head>
<body>
    <h1><?php echo $message?></h1>
    <a href="index.php">トップページへ</a>
</body>
</html>


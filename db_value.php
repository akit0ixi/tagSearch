<?php
require('db_connection.php');

// カテゴリ名を取得（未ログイン）
$sql = 'select distinct categories.category_name from categories join words on categories.id = words.category_id where words.user_id = 0 order by words.date desc'; #ここにリミットをかければ未ログイン時カテゴリ表記数を変更可
$stmt = $db->query($sql);
$result = $stmt->fetchall();
$cNames = $result;
// $cName1 = $result[0]['category_name']; 
// $cName2 = $result[1]['category_name']; 
// $cName3 = $result[2]['category_name']; 



// // カテゴリ名に一致するidの取得
$exam = h($_POST['cate']);
// $exam = '仕事';
$sql = 'select id from categories where category_name = :cname ';
$stmt = $db->prepare($sql);
$stmt->bindValue('cname',$exam,PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchall();
$cate_id = $result[0]['id'];

// 選択カテゴリに登録されている単語数(未ログイン)
// $exId=1;
$exId = $cate_id;
$sql = 'select count(category_id) from words where category_id = :cid and user_id = 0';
$stmt = $db->prepare($sql);
$stmt->bindValue('cid',$exId,PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchall();
$countWds= $result[0]['count(category_id)'];

// 選択カテゴリに対する登録単語(未ログイン)
// $seId = 1;
$seId = $cate_id;
$sql = 'select word from words where category_id = :sid and user_id = 0 order by words.date desc';
$stmt = $db->prepare($sql);
$stmt->bindValue('sid',$seId,PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchall();
$select_words= $result;

// ログイン時のユーザid取得
if (!empty($_POST['user_name'])) {
    $sql = 'select * from users';
    $stmt = $db->query($sql);
    $result = $stmt->fetchall();
    foreach($result as $key => $value){
        if(h($_POST['user_name'])===$value['name'] && password_verify(h($_POST['user_pass']),$value['password'])){
            $login_id = $value['id'];
        }
    }
}

// ユーザ毎の選択カテゴリに対する登録単語

$seId = $cate_id;
$sql = 'select word from words where category_id = :sid and user_id = :uid';
$stmt = $db->prepare($sql);
$stmt->bindValue('sid',$seId,PDO::PARAM_INT);
$stmt->bindValue('uid',$_SESSION['login_id'],PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchall();
$users_words= $result;

// ユーザ専用の選択カテゴリに登録されている単語数

$exId = $cate_id;
$sql = 'select count(category_id) from words where category_id = :cid and user_id = :uid';
$stmt = $db->prepare($sql);
$stmt->bindValue('cid',$exId,PDO::PARAM_INT);
$stmt->bindValue('uid',$_SESSION['login_id'],PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchall();
$count_uWds= $result[0]['count(category_id)'];

// ユーザが登録したカテゴリ一覧
$sql = 'select distinct categories.category_name from categories join words on categories.id = words.category_id where words.user_id = :uid';
$stmt = $db->prepare($sql);
$stmt->bindValue('uid',$_SESSION['login_id'],PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchall();
$ucates_name = $result;







echo "<pre class='mt-5'>";
// var_dump($result);
// var_dump($cName1);#カテゴリ名１
// var_dump($cName2);#カテゴリ名２
// var_dump($cName3);#カテゴリ名３
// var_dump($cate_count);#カテゴリ数
// var_dump($cate_id);#選択したカテゴリ名に対するカテゴリID
// var_dump($countWds);#選択したカテゴリ名に対する単語数
// var_dump($select_words);#選択したカテゴリ名に対する登録単語
// var_dump($users_words);#ユーザに対するカテゴリ名
// var_dump($login_id);#ユーザに対するカテゴリ名
// var_dump($count_uWds);#ユーザに対するカテゴリ名

echo '</pre>';


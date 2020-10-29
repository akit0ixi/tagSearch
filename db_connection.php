<?php

const DB_HOST = 'mysql:dbname=searchwords;host=127.0.0.1;charset=utf8';
const DB_USER = 'php_user';
const DB_PASSWORD = 'password123';

try{
    $db = new PDO(DB_HOST,DB_USER,DB_PASSWORD,[
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //連想配列で取得
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//警告は例外モード
        PDO::ATTR_EMULATE_PREPARES => false,//SQLインジェクション対策
    ]);
    echo "接続成功";
}catch(PDOExeption $e){
    echo '接続失敗'.$e->getMessage()."\n";
    exit();
}
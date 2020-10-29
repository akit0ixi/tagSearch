<?php
// -------------------------
// 定数設定
// -------------------------



// APIキー
$apiKey = "AIzaSyAdLaxIGAOAJrUnbtp-85dY9Y6qDhEGkIM";

// 検索エンジンID
$searchEngineId = "55020ec92119849b5";

// 検索用URL
$baseUrl = 'https://www.googleapis.com/customsearch/v1?';

// 取得開始位置
$startNum = 1;

// -------------------------
// 検索キーワード取得
// -------------------------
// if (!mb_strlen($_POST['q'])===0) {

    $query = h($_POST['q']);
    // $query="原神";
    
    // -------------------------
    // リクエストパラメータ生成
    // -------------------------
    $paramAry = array(
        'q' => $query,
        'key' => $apiKey,
        'cx' => $searchEngineId,
        'alt' => 'json',
        'start' => $startNum,
        'num' => 3
    );
    
    $param = http_build_query($paramAry);
    
    
    // -------------------------
    // 実行＆結果取得
    // -------------------------
    $reqUrl = $baseUrl.$param;
    $retJson = file_get_contents($reqUrl,true);
    $ret = json_decode($retJson,true);
    
    
    // -------------------------
    // 結果表示
    // -------------------------
    
    // 画面表示
    // echo '<pre>';
    // var_dump($ret);
    // echo '</pre>';
    // echo"=======================================<br>\n";
    // 項目を画面表示
    $num = $startNum;
    foreach($ret['items'] as $value){
        echo '順位'.$num."<br>\n";
        echo 'タイトル'.$value['title']."<br>\n";
        echo 'URL'.$value['link']."<br>\n";
        echo "---------------------------------------------------------------------------<br>\n";
        $num ++;
    }
// }
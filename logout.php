<?php
session_start();

$_SESSION = array();

setcookie(session_name(), '', time() - 42000, '/');

session_destroy();
?>

<html lang="ja">
<head>
<meta charset="utf-8">
<title>ログアウト</title>
</head>
<body>
    <h1>ログアウトしました</h1>
    <a href="index.php">トップページへ</a>
</body>
</html>
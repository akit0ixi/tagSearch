<?php
// ini_set("display_errors",1);
// error_reporting(E_ALL);

// session
session_start();

// バリデーション処理
require ('validation.php');
validation($_POST);
// require ('db_connection.php');
require ('db_value.php');

// 透過広告などを防ぐ
header('X-FRAME-OPTIONS:DENY');

// 特殊文字の処理をする短縮関数定義
function h($str){
  return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}



// ログイン機構
if (isset($login_id)) {
  $_SESSION['login_id']= $login_id;
}

// echo password_hash('pass1234',PASSWORD_BCRYPT);



// ページ切り替え処理
$pageFlag = 0; #初期ページは0
if (!empty($_POST['reset']) || !empty($_POST['cate_reset'])) { #トップページに戻る
  $_SESSION['search_category']="";
  $pageFlag =0;
} elseif (!empty($_POST['cate'])) { #カテゴリを選択時の画面
  $pageFlag =1;
} elseif (!empty($_POST['cate_sub'])) { #カテゴリ登録時
  $pageFlag = 2;
} elseif (!empty($_POST['search'])) { #検索結果画面
  $pageFlag = 3;
} elseif (!empty($_POST['after_cate_sub'])) { #カテゴリ未選択で検索後カテゴリ選択時
  $pageFlag = 4;
}







// 確認用
// echo "<pre class='mt-5'>";
// var_dump($_SESSION);
// var_dump($_POST);
// // var_dump($_POST['user_pass']);
// // var_dump($_POST['user_put']);
// var_dump($pageFlag);
// var_dump($error);
// echo "</pre>";
?>

<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- fontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <!-- style -->
    <link rel="stylesheet" href="css/style.css">
    <title>ぐーぐる検索</title>
  </head>
  <body>
  <!-- ヘッダー -->
  <nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
        <a class="navbar-brand text-white" href="index.php">けんさくきろく</a>
        <!-- ログインモーダルトリガー -->
        <?php if (!isset($_SESSION['login_id'])) :?>
        <button type="button" class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#loginModal">ログイン</button>
        <?php else:?>
        <a type="button" href="logout.php" class="btn btn-outline-success my-2 my-sm-0">ログアウト</a>
        <?php endif;?>
    </nav>
    <!-- ログインモーダル -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalTitle">ログイン</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="index.php">
                <div class="modal-body text-center">
                    <label for="user_name">ユーザー名</label>
                    <input class="m-1" type="text" name="user_name" size="30" maxlength="20">
                    <br>
                    <label for="user_pass">パスワード</label>
                    <input class="m-1" type="password" name="user_pass" size="30" maxlength="20">
                </div>
                <div class="modal-footer">
                <!-- 新規登録モーダルトリガー -->
                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#signUpModal">新規登録</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <input type="submit" value="ログイン" class="btn btn-info" name="user_log">
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 新規登録モーダル -->
    <div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signUpModalTitle">新規登録</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="signup.php">
                <div class="modal-body">
                    <label for="sign_user_name">ユーザー名</label>
                    <input type="text" name="sign_user_name" size="40" maxlength="20">
                    <label for="sign_user_pass">パスワード</label>
                    <input type="password" name="sign_user_pass" size="40" maxlength="20">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <input type="submit" value="登録する" class="btn btn-info" name="suser_log">
                </div>
                </form>
            </div>
        </div>
    </div>
  <!-- ヘッダーここまで -->
  
  <!-- ログインメッセージの表示 -->
  <?php if (!empty($_POST['user_log'])) :?>
    <?php if (!empty($_SESSION['login_id'])) :?>
      <p class="m-3"><?php echo h($_POST['user_name']);?>,Wellcome!</p>
      <form method="POST" action="index.php">
        <input type="submit" value="カテゴリを表示する" name="cate_reset">
      </form>
    <?php else:?>
      <p>ユーザ名もしくは、パスワードが違います</p>
    <?php endif;?>
  <?php endif;?>

  <!-- タイトル -->
    <h1 class="m-3">ぐーぐる検索</h1>
  <!-- 検索バー -->
    <form method="POST" id="cse-search-box" action="index.php" class="search_container">
    <input type="hidden" name="ie" value="UTF-8" >
    <input type="text" name="q" size="60" value="<?php echo h($_POST['q']??"")?>" placeholder="キーワード検索">
    
    <input type="submit" name="search"  value="&#xf002;" class="fas">
    </form>
  <!-- カテゴリ表示 -->
    <div class="border">
      <?php if ($pageFlag === 0) :?>
      <h3>カテゴリ一覧</h3>
      <form method="POST" action="index.php">
      <?php if (!isset($_SESSION['login_id'])) :?>
        <?php foreach ($cNames as $key => $values) :?>
        <?php foreach ($values as $value) :?>

        <input type="submit" value="<?php echo $value;?> " name="cate" class="catebtn m-1">
        <!-- <a href="" class="btn btn-radius-solid">PUSH！<i class="fas fa-angle-right fa-position-right"></i></a> -->
        <?php endforeach;?>
        <?php endforeach;?>
      <?php else:?>
        <?php foreach ($ucates_name as $key => $values) :?>
        <?php foreach ($values as $value) :?>
        <input type="submit" value="<?php echo $value;?>" name="cate" class="catebtn m-1">
        <?php endforeach;?>
        <?php endforeach;?>
      <?php endif;?>
        <!-- 追加ボタン -->
      <?php if (isset($_SESSION['login_id'])) :?>
        <button type="button" class="btn  btn-info addbtn" data-toggle="modal" data-target="#addCell">追加</button>
        <!-- 追加ボタン押下後のモーダル表示 -->
        <div class="modal fade" id="addCell" tabindex="-1" role="dialog" aria-labelledby="addCellModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCellModalTitle">ジャンル追加</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="new_category">
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                       <input type="submit" value="登録" class="btn btn-info" name="cate_sub">
                    </div>
                </div>
            </div>
        </div> 
      <?php endif;?>   
      </form>
    <?php endif;?>

    <?php if ($pageFlag===1) :?>
    <form method="POST" action="index.php">
    
    <!-- 該当ワードを全て出力 -->
    <h4><?php echo $_POST['cate'];?></h4>
      <?php if (!isset($_SESSION['login_id'])) :?>
    <!-- 未ログイン時 -->
        <?php foreach ($select_words as  $key => $values) :?>
        <?php foreach ($values as $value) :?>
            <input type="submit" class="m-1 wordbtn" value="<?php echo $value;?>" name="q">
        <?php endforeach;?>
        <?php endforeach;?>
      <?php else:?>
          <!-- ログイン時 -->
        <?php foreach ($users_words as  $key => $values) :?>
        <?php foreach ($values as $value) :?>
            <input type="submit" value="<?php echo $value;?>" name="q">
        <?php endforeach;?>
        <?php endforeach;?>
      <?php endif;?>
      <br>
      <input type="submit" class="mt-3 topbtn" value="トップに戻る" name="reset">
      <input type="hidden" value="wordSelect" name="search">
    </form>
    <?php $_SESSION['search_category'] = h($_POST['cate']); ?>
    <?php endif;?>


    <!-- カテゴリを新規入力した場合 -->
    <?php if ($pageFlag === 2) :?>
    
    <!-- dbにカテゴリリストを追加-->
    <?php require('insert.php');?>
    
    <!-- 検索前処理（カテゴリ情報保存） -->
    <?php $_SESSION['search_category'] = h($_POST['new_category']); ?>
    <?php endif;?>

    <!-- 検索結果の表示 -->
    <?php if ($pageFlag === 3) :?>
    <!-- カテゴリ表示 -->
    <?php if (empty($_SESSION['search_category'])) :?>
      <form method="POST" action="index.php">
      <?php if (!isset($_SESSION['login_id'])) :?>
        <?php foreach ($cNames as $key => $values) :?>
        <?php foreach ($values as $value) :?>
        <input type="radio" value="<?php echo $value;?>" name="after_cate"><?php echo $value;?>
        <?php endforeach;?>
        <?php endforeach;?>
      <?php else:?>
        <?php foreach ($ucates_name as $key => $values) :?>
        <?php foreach ($values as $value) :?>
        <input type="radio" value="<?php echo $value;?>" name="after_cate"><?php echo $value;?>
        <?php endforeach;?>
        <?php endforeach;?>
      <?php endif;?> <!-- ログインされているかに対する閉じタグ -->
        <br>
        <input type="submit" value="このカテゴリに登録する" name="after_cate_sub">
        <?php $_SESSION['word'] = "" ;?>
        <?php $_SESSION['word'] = h($_POST['q']) ;?>
    </form>
    <?php endif;?><!-- $_SESSIONの値が空かに対する閉じタグ -->
    
    <?php require ('smsearch.php');?>
    <!-- 検索結果表示デザイン -->
    
    <!-- 検索単語登録 -->
    <?php require ('wordinsert.php');?>
    
    
    <form method="POST" action="index.php">
    <input type="submit" class="mt-3 topbtn" value="トップに戻る" name="cate_reset">
    </form>
    
    <?php endif;?> <!-- $pageFlagに対する閉じタグ -->
    
    <!-- 検索後カテゴリ選択時 -->
    <?php if ($pageFlag === 4) :?>
      <?php require ('after_wordinsert.php');?>
    <p>単語登録完了しました</p>
    <form method="POST" action="index.php">
    <input type="submit" class="mt-3 topbtn" value="トップに戻る" name="cate_reset">
    </form>
    <?php endif;?>
    
  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>


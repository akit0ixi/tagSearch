<?php
function validation($data) {
    $error = array();

    // -------------------------
    // ログイン時
    // -------------------------

    if (!empty($data['user_log'])) {
        // ユーザー名
        if (empty($data['user_name']) || 20 < mb_strlen($data['user_name'])) {
            $error['user_name'] = "ユーザー名は20文字以内で入力してください";
        }
        
        // パスワード
        if (empty($data['user_pass'] || 20 < mb_strlen($data['user_pass'] || 6 > mb_strlen($data['user_pass'])))) {
            $error['user_pass'] ="パスワードは6文字以上20文字以内で入力してください";
        } else {
            $GLOBALS['input_pass'] = password_hash($data['user_pass'],PASSWORD_BCRYPT);
        }
    }
    
   
    // -------------------------
    // 新規登録時
    // -------------------------
    
    if (!empty($data['suser_log'])) {
        
        // ユーザー名
        if (empty($data['sign_user_name']) || 20 < mb_strlen($data['sign_user_name'])) {
            $error['sign_user_name'] = "ユーザー名は20文字以内で入力してください";
        }
        
        // パスワード
        if (empty($data['sign_user_pass'] || 20 < mb_strlen($data['sign_user_pass'] || 6 > mb_strlen($data['sign_user_pass'])))) {
            $error['sign_user_pass'] ="パスワードは6文字以上20文字以内で入力してください";
        } else {
            $GLOBALS['sign_input_pass'] = password_hash($data['sign_user_pass'],PASSWORD_BCRYPT);
        }
    }
     
    
    //検索単語
    if (mb_strlen($data['q']) === 0) {
        $error['q'] = "検索単語を正しく入力してください";
    }

    // カテゴリ登録時
    if (empty($data['new_category']) || 20 < mb_strlen($data['new_category'])) {
        $error['new_category'] = "カテゴリ名は20文字以内で入力してください";
    } 

    // カテゴリ選択時
    if (20 < mb_strlen($data['cate'])) {
        $error['cate'] = "カテゴリを正しく選択してください";
    }

    // after_cate選択時
    if (20 < mb_strlen($data['after_cate'])) {
        $error['after_cate'] = "カテゴリを正しく選択してください";
    }

    return $error;

}




// user_name 0
// user_pass 0
// user_log 0
// sign_user_name signup.php
// sign_user_pass signup.php
// q 3
// ie = utf-8 3
// login_id
// new_category 2
// cate_sub 2
// cate 1  
// cate_reset 0
// after_cate 4

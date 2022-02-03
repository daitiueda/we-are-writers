<?php

if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}
//以下バリデーション処理
$_SESSION['form']['errors'] = [];

if (!isset($_POST['id']) || !isset($_POST['token']) || !isset($_POST['password']) || !isset($_POST['password_confirm'])) {
    $_SESSION['form']['errors'][] = '必須パラメータが不足しています。';
} else {
    
    $dsn = 'mysql:host=localhost; dbname=db_local; charset=utf8';
    $db_username = 'root';
    $db_password= 'root';
    try {
        $dbh = new PDO($dsn, $db_username, $db_password);
    } catch (PDOException $e) {
        $msg = $e->getMessage();
        // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
        // exit();
    }
    
    // tokenのレコードを取得
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $_POST['id']);
    $stmt->execute();
    $member = $stmt->fetch();
    
    if ($member === false) {
        // レコードが存在しない場合
        $_SESSION['form']['errors'][] = '不正なURLからのアクセスです。';
    } else {
        // 値が不正であればエラーメッセージをセット
        if ($member['user_type'] === 0 || $member['password_reset_token'] == '') {
            $_SESSION['form']['errors'][] = '不正なURLからのアクセスです。';
        } elseif (!password_verify($_POST['token'], $member['password_reset_token'])) {
            $_SESSION['form']['errors'][] = '不正なURLからのアクセスです。';
        } else {
            if ( mb_strlen($_POST["password"]) < 8 || 20 < mb_strlen($_POST["password"]) ){
                $_SESSION['form']['errors']['password'] = 'パスワードは8字以上20字以内で入力して下さい';
        
            } elseif($_POST['password'] !== $_POST['password_confirm']) {
                $_SESSION['form']['errors']['password'] = 'パスワード（確認）にはパスワードの入力欄と同じものを入力してください。';
            }
        }
    }
}

// $_SESSION['form']['erorrs']が空であればパスワードを更新、空でなければリダイレクト
if($_SESSION['form']['errors'] === []){
    // DBに本登録会員としてupdate 
    $sql = "UPDATE users SET password = :password, password_reset_token = '' WHERE id = {$member['id']}";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':password', $_POST['password']);
    $stmt->execute();
} else {
    // 入力値を$_SESSION['form']['input']にセット
    $_SESSION['form']['input']['id'] = $_POST['id'];
    $_SESSION['form']['input']['email'] = $_POST['token'];
    $_SESSION['form']['input']['password'] = $_POST['password'];
    header("Location:http://{$_SERVER['HTTP_HOST']}/account/account_create.php");
    exit();
}

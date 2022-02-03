<?php

if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}

//以下バリデーション処理
$_SESSION['form']['errors'] = [];
// $_POST['name']
if (empty($_POST['name'])){
    $_SESSION['form']['errors']['name'] = '名前は入力必須です';
} else {
    if (mb_strlen($_POST['name']) > 50) {
        $_SESSION['form']['errors']['name'] = '名前は50字以内で入力してください。';
    }
}
// $_POST['email']
if (empty($_POST["email"])){
    $_SESSION['form']['errors']['email'] = 'メールアドレスは入力必須です';
}
// $_POST['password']
if (empty($_POST["password"])){
    $_SESSION['form']['errors']['password'] = 'パスワードは入力必須です';
} else {
    if ( mb_strlen($_POST["password"]) < 8 || 20 < mb_strlen($_POST["password"]) ){
        $_SESSION['form']['errors']['password'] = 'パスワードは8字以上20字以内で入力して下さい';

    } elseif($_POST['password'] !== $_POST['password_confirm']) {
        $_SESSION['form']['errors']['password'] = 'パスワード（確認）にはパスワードの入力欄と同じものを入力してください。';
    }
}
// $_SESSION['form']['erorrs']が空でなければリダイレクト
if($_SESSION['form']['errors'] !== []){
// 入力値を$_SESSION['form']['input']にセット
    $_SESSION['form']['input']['name'] = $_POST['name'];
    $_SESSION['form']['input']['email'] = $_POST['email'];
    $_SESSION['form']['input']['password'] = $_POST['password'];
    header("Location:http://{$_SERVER['HTTP_HOST']}/account/account_create.php");
    exit();
}

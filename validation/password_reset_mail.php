<?php

if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}

//以下バリデーション処理
$_SESSION['form']['errors'] = [];
// $_POST['email']
if (empty($_POST["email"])){
    $_SESSION['form']['errors']['email'] = 'メールアドレスは入力必須です';
}

// $_SESSION['form']['erorrs']が空でなければリダイレクト
if($_SESSION['form']['errors'] !== []){
// 入力値を$_SESSION['form']['input']にセット
    $_SESSION['form']['input']['email'] = $_POST['email'];
    header("Location:http://{$_SERVER['HTTP_HOST']}/password_reset_mail.php");
    exit();
}

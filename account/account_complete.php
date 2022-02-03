<?php

// バリデーション
include('../validation/account.php');

//フォームからの値をそれぞれ変数に代入
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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

//フォームに入力されたmailがすでに登録されていないかチェック
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->execute();
$member = $stmt->fetch();

if ($member !== false) {
    $msg = '同じメールアドレスが存在します。';
    // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
    // exit();
} else {
    //登録されていない場合

    // 登録トークンを生成
    $email_token = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 15, 20);
    $record_token = password_hash($email_token, PASSWORD_DEFAULT);
    $token_url = "http://{$_SERVER['HTTP_HOST']}/account/account_registered.php?name={$name}&token={$email_token}";

    // DBにinsert 
    $sql = "INSERT INTO users(name, email, password, user_type, password_reset_token) VALUES (:name, :email, :password, 0, :password_reset_token)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->bindValue(':password_reset_token', $record_token);
    $stmt->execute();

    //Fromヘッダーを作成
    $header = 'From: ' . mb_encode_mimeheader($name). '様 <' . $email. '>';
    // タイトルと本文をセット
    $subject = '仮登録の完了【小説投稿サイト「We are writers!」】';
    $body = "{$name}様、小説投稿サイト「We are writers!」にご登録くださりありがとうございます。\r\n以下のリンクをクリックして、本登録操作を完了してください。\r\n \r\n {$token_url} \r\n \r\n \r\n ※このメールに心覚えがない場合は、このメールを削除してください。";

    include('../vendor/env.php');

    if (MODE === 'run') {
        // 本登録完了メール送信
        mb_language('ja');
        mb_internal_encoding('UTF-8');
        // メール送信
        if (mb_send_mail($email, $subject, $body, $header, '-f'. 'novel_sercice@localhost')) {
            // メール送信成功
        } else {
            // メール送信失敗
            $msg = '登録に失敗しました。';
            // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
            // exit();
        }
    } elseif(MODE === 'debug') {
        // デバッグモードの時は、テキストファイルに書き込む
        file_put_contents(__DIR__.'\mail\mails_at_'.date('Y-m-d-H:i:s').'.txt', $subject."\r\n".$body, FILE_APPEND);
    }
    
}

// ヘッダー読み込み
include('../common/header.php');
?>
<div class="top_page">
          <!-- <div class="hello indexhello"> -->
            <div class="com_top1">登録完了<br>Completion registration</div>
            <div class="com_top2"></div>
            <div class="com_top3"></div>
            <div class="com_top4"></div>
            <div class="com_top5"></div>
            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/index.php" class="com_top6">
            Home▶︎
          </a>
            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/mypage.php" class="com_top7" >
            My page▶︎
          </a>
            <div class="com_top8"></div>
 </div>
<?php
// フッター読み込み
include('../common/footer.php');
?>
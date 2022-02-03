<?php 
// バリデーションして、パスワード再設定メールを送信する

// バリデーション
include('../validation/reset_password.php');

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

//フォームに入力されたmailのレコードを取得
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->execute();
$member = $stmt->fetch();

if ($member === false) {
    $msg = '入力されたメールアドレスは存在しません。';
    // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
    // exit();
} else {
    //登録されている場合

    // パスワード再設定トークンを生成
    $email_token = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 15, 20);
    $record_token = password_hash($email_token, PASSWORD_DEFAULT);
    $token_url = "http://{$_SERVER['HTTP_HOST']}/account/password_reset_input.php?id={$member['id']}&token={$email_token}";

    // DBにpassword_reset_tokenを入れてupdate 
    $sql = "UPDATE INTO users SET password_reset_token = {$record_token} WHERE id = {$member['id']}";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    //Fromヘッダーを作成
    $header = 'From: ' . mb_encode_mimeheader($name). '様 <' . $email. '>';
    // タイトルと本文をセット
    $subject = 'パスワード再設定用のリンクの送信【小説投稿サイト「We are writers!」】';
    $body = "{$name}様へ\r\n小説投稿サイト「We are writers!」にご利用いただきありがとうございます。\r\n以下のリンクをクリックして、パスワード再設定操作を完了してください。\r\n \r\n {$token_url} \r\n \r\n \r\n ※このメールに心覚えがない場合は、このメールを削除してください。";

    include('../vendor/env.php');

    if (MODE === 'run') {
        // パスワード再設定メール送信
        mb_language('ja');
        mb_internal_encoding('UTF-8');
        // メール送信
        if (mb_send_mail($email, $subject, $body, $header, '-f'. 'novel_sercice@localhost')) {
            // メール送信成功
        } else {
            // メール送信失敗
            $msg = '再設定メールの送信に失敗しました。';
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
    <h1>パスワード再設定メール送信ページ</h1>

    <div><?= $_POST['email'] ?>にパスワード再設定用のメールを送信しました。メールをご確認ください。</div>

    <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/index.php">トップページに戻る</a>
<?php
// フッター読み込み
include('../common/footer.php');
?>
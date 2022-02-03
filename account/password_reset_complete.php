<?php

// バリデーション
include('../validation/password_reset.php');


if (!isset($_POST['id']) || !isset($_POST['token']) || !isset($_POST['password']) || !isset($_POST['password_confirm'])) {
    // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
    // exit();
}

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
    // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
    // exit();
} else {
    // 値が不正であればリダイレクト
    if ($member['user_type'] !== 0 || $member['password_reset_token'] == '') {
        // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
        // exit();
    } elseif (!password_verify($_GET['token'], $member['password_reset_token'])) {
        // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
        // exit();
    }

    // DBに本登録会員としてupdate 
    $sql = "UPDATE users SET user_type = 1, password_reset_token = '' WHERE id = {$member['id']}";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
}

// ヘッダー読み込み
include('../common/header.php');
?>
  <?php include "header.php"?>
    <h1>パスワード変更完了</h1>
    <p>新しいパスワードに変更しました</p>
<?php
// フッター読み込み
include('../common/footer.php');
?>
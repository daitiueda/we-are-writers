<?php

// ログアウト処理を行う。

if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}
// セッションを空に
$_SESSION = [];

// ヘッダー読み込み
include('../common/header.php');
?>

<h1>ログアウトが完了しました</h1>

<a href="http://<?= $_SERVER['HTTP_HOST'] ?>/index.php">トップページへ</a>
<a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/login.php">ログイン</a>

<?php
$_SESSION['form'] = [];
// フッター読み込み
include('../common/footer.php');
?>

<?php 
// env.php を読み込み
include('../vendor/env.php');

if (session_status() == PHP_SESSION_NONE) {
  // セッションは有効で、開始していないとき
  session_start();
}

if (!isset($_GET['novel_id']) || !isset($_GET['chapter_id'])) {
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}

try {
  $dbh = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; chaarset=utf8', DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
  $msg = $e->getMessage();
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}

// ヘッダー読み込み
include('../common/header.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<link rel="stylesheet" href=".css">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
  <div class="page">
    <form action= "http://<?= $_SERVER['HTTP_HOST'] ?>/novel/novel_comfirm.php" method="post" class="submit_form">
        <p>Novel Title<br><input type="text" name="title" value="<?= $_SESSION['form']['input']['title'] ?? '' ?>" placeholder="小説タイトル"></p>
        <p>Category<br><input type="text" name="category" value="<?= $_SESSION['form']['input']['category'] ?? '' ?>" placeholder="カテゴリー"></p>
        <p>Overview<br><textarea name="summary" id="" cols="30" rows="10"  placeholder="小説概要"><?= $_SESSION['form']['input']['summary'] ?? '' ?></textarea></p>
        <input type="hidden" name="user" value="<?=$_POST['user'] ?? '' ?>">
        <div class="submit_button"><button type="submit">投稿</button></div>
    </form>
  </div>
  </body>
</html>
<?php
// フッター読み込み
include('../common/footer.php');
?>
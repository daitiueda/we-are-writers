<?php 


// ログイン状態でなければログインページにリダイレクト
if (!isset($_SESSION['user']) || $_SESSION['user'] === []) {
  include('../vendor/auth.php');
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
  header("Location:http://{$_SERVER['HTTP_HOST']}/account/login.php");
  exit();
}

// アカウント削除処理
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

$delete_id = $_SESSION['user']['id'];
// 削除するレコードを取得
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $delete_id);
$stmt->execute();
$member = $stmt->fetch();

if ($member === false) {
    // レコードが存在しない場合
    // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
    // exit();
} else {
  // レコードを削除する
  // user_favoritesテーブル
  $sql = 'DELETE FROM user_favorites WHERE user_id = :user_id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':user_id', $delete_id);
  $stmt->execute();
  // chapter_votesテーブル
  $sql = 'DELETE FROM chapter_votes WHERE user_id = :user_id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':user_id', $delete_id);
  $stmt->execute();
  // offered_chaptersテーブル
  $sql = 'DELETE FROM offered_chapters WHERE user_id = :user_id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':user_id', $delete_id);
  $stmt->execute();
  // novelsテーブル
  $sql = 'DELETE FROM novels WHERE user_id = :user_id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':user_id', $delete_id);
  $stmt->execute();
  // usersテーブル
  $sql = 'DELETE FROM users WHERE id = :id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':id', $delete_id);
  $stmt->execute();
}

// ヘッダー読み込み
include('common/header.php'); 
?>
  <p>退会が完了しました！<br>またのご利用をお待ちしております！</p>
  <button><a href="http://<?= $_SERVER['HTTP_HOST'] ?>index.php">HOMEへ</a></button>
<?php
// フッター読み込み
include('common/footer.php');
?>
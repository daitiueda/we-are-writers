<?php 

// ログイン状態でなければログインページにリダイレクト
if (!isset($_SESSION['user']) || $_SESSION['user'] === []) {
  include('../vendor/auth.php');
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
  header("Location:http://{$_SERVER['HTTP_HOST']}/account/login.php");
  exit();
}

// ヘッダー読み込み
include('common/header.php');
?>
    <h1>退会ページ</h1>
    <p>マイページが利用出来なくなり、今まで投稿した小説やお気に入り登録がすべて削除されてしまいます。</p>
    <p>本当によろしいですか？</p>
    <button onclick="history.back(-1);return false;">修正</button>
    <button><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/leave_complete.php">退会</a></button>
<?php
// フッター読み込み
include('../common/footer.php');
?>

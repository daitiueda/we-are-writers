<?php 
// このページのタイトルを設定
$title = 'ログイン';

if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}
// ヘッダー読み込み
include('../common/header.php');
?>
  <?php $redirect_url = $_SESSION['redirect_url'] ?? 'account/mypage.php'; ?>
<div class="top_page">
          <!-- <div class="hello indexhello"> -->
            <div class="log_top1">Login</div>
            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/account_create.php" class="log_top2">▶︎Create account</a>
            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/password_reset_mail.php" class="log_top3">▶︎Reset password</a>
            <div class="log_top6">  
                <?php $redirect_url = $_SESSION['redirect_url'] ?? 'account/mypage.php'; ?>
    <form action="http://<?= $_SERVER['HTTP_HOST'].'/'.($redirect_url === '' ? $redirect_url:'account/mypage.php') ?>" method="post" class="submit_form">
        <p>Mail adress<br><input type="text" name="email" required value="<?= $_SESSION['form']['input']['email'] ?? '' ?>" placeholder="メールアドレス"></p>
        <p>Password<br><input type="password" name="password"  placeholder="パスワード">   
        <div class="submit_button"><button type="submit">Login!</button></div>
    </form>
  </div>
  <div class="log_top7"></div>
  <div class="log_top8"></div>
  <div class="log_top9"></div>
  <div class="log_top10"></div>
  <div class="log_top11"></div>
</div>
 </div>
 <!-- <div class="page">
    <div class="page_comment">
      <p>ログインするためには登録したメールアドレス、パスワードが必要になります</p>
      <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/account_create.php">アカウント新規作成</a>
      <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/password_reset_mail.php">パスワードを忘れた方はこちら</a>
    </div>

    <?php $redirect_url = $_SESSION['redirect_url'] ?? 'account/mypage.php'; ?>
    <form action="http://<?= $_SERVER['HTTP_HOST'].'/'.($redirect_url === '' ? $redirect_url:'account/mypage.php') ?>" method="post" class="submit_form">
        <p>Mail adress<br><input type="text" name="email" required value="<?= $_SESSION['form']['input']['email'] ?? '' ?>" placeholder="メールアドレス"></p>
        <p>Password<br><input type="password" name="password"  placeholder="パスワード">   
        <div class="submit_button"><button type="submit">Login!</button></div>
    </form>
  </div> -->

  <!-- ページデザイン -->
    <div>
    <?php 
    foreach(($_SESSION['form']['errors'] ?? []) as $error){
        echo "<div>{$error}</div>";
    }
    ?>
    </div>
<div>
    <?php 
    foreach(($_SESSION['form']['errors'] ?? []) as $error){
        echo "<div>{$error}</div>";
    }
    ?>
</div>

<?php
$_SESSION['form'] = [];
// フッター読み込み
include('../common/footer.php');
?>
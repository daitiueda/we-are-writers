<?php 
// このページのタイトルを設定
$title = 'ログイン';
// ヘッダー読み込み
include('../common/header.php');

if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}
?>
<!-- html -->
<div class="top_page">
          <!-- <div class="hello indexhello"> -->
            <div class="sub_top1">Story <br>drawn <br>by everyone</div>
            <div class="sub_top2">Create account</div>
            <div class="sub_top3"></div>
            <div class="sub_top4">アカウントを作成をすることで<br>小説の投稿やお気に入り登録が可能になります</div>
            <div class="sub_top5"></div>
            <div class="sub_top6"></div>
            <div class="sub_top7"></div>
            <div class="sub_top8"></div>
 </div>

  <!-- ページデザイン -->
  <div class="page">
    <div class="page_comment">
      <p>アカウントの新規作成を行うためには名前、登録していないメールアドレス、パスワードの登録が必要になります</p>
    </div>
    <form action="http://<?= $_SERVER['HTTP_HOST'] ?>/account/account_complete.php"  method="post" class="submit_form">
        <p>Name<br><input type="text" name="name" value="<?= $_SESSION['form']['input']['name'] ?? '' ?>" placeholder="名前"></p>
        <p>Mail adress<br><input type="email" name="email" value="<?= $_SESSION['form']['input']['email'] ?? '' ?>" placeholder="メールアドレス"></p>
        <p>Password<br><input type="password" name="password" value="<?= $_SESSION['form']['input']['email'] ?? '' ?>" placeholder="パスワード"></p>
        <p>Password confirm<br><input type="password" name="password_confirm" value="<?= $_SESSION['form']['input']['password'] ?? '' ?>" placeholder="パスワード（確認）"></p>
        <div class="submit_button"><button type="submit">Join!</button></div>
    </form>
  </div>
  <!-- ページデザイン -->
    <div>
    <?php 
    foreach(($_SESSION['form']['errors'] ?? []) as $error){
        echo "<div>{$error}</div>";
    }
    ?>
    </div>
</body>
</html>
<?php
$_SESSION['form'] = [];
// フッター読み込み
include('../common/footer.php');
?>
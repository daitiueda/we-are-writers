<?php 
// ヘッダー読み込み
include('../common/header.php');
?>
    <h1>パスワード再設定メール送信ページ</h1>
    <?php 
    foreach(($_SESSION['form']['errors'] ?? []) as $error){
        echo "<div>{$error}</div>";
    }
    ?>
    <form action="http://<?= $_SERVER['HTTP_HOST'] ?>/account/password_reset_mail_sent.php" method="POST">
      <p>登録済みのメールアドレスを下記の欄に入力して下さい</p>
      <p>入力されたメールアドレスへメールアドレス変更用のリンクが記載されたメールを送信します</p>
      <p>送られてきたメールのリンクをクリックしてパスワード再設定の手続きをして下さい</p>
      <dl>
        <dt>
          <label for="">メールアドレス</label>
          <span class="kome">*</span>
        </dt>
        <dd>
          <input type="mail" name="email" placeholder="a1234567@gmail.com" value="<?= $_SESSION['form']['input']['email'] ?? '' ?>">
        </dd>
        <dl>
          <dd><button type="submit">送信</button></dd>
        </dl>
        </dl>
      </form>
<?php 
$_SESSION['form'] = [];
// フッター読み込み
include('../common/footer.php');
?>

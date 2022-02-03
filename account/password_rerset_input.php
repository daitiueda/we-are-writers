<?php 
// 送信されたリンクが正しいものか検証

$id = $_GET['id'] ?? ($_POST['id'] ?? '');
$token = $_GET['token'] ?? ($_POST['token'] ?? '');

if ($id === '' || $token === '') {
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}

// ヘッダー読み込み
include('../common/header.php');
?>

    <?php 
    foreach(($_SESSION['form']['errors'] ?? []) as $error){
        echo "<div>{$error}</div>";
    }
    ?>
    <form action="http://<?= $_SERVER['HTTP_HOST'] ?>/account/password_reset_complete.php" method="POST">
      <input type="hidden" name="id" value="<?= $id ?>">
      <input type="hidden" name="token" value="<?= $token ?>">
      <h1>パスワード新規作成</h1>
      <p>パスワードの新規作成をします</p>
      <p>新しいパスワードを入力して下さい</p>
      <dl>
        <dt>
          <label for="password">パスワード</label>
          <span class="kome">*</span>
        </dt>
        <dd>
          <input type="password" name="password">
        </dd>
        <dt>
          <label for="">パスワード（確認）</label>
          <span class="kome">*</span>
        </dt>
        <dd>
          <input type="password" name="password_confirm">
        </dd>
        </dl>
          <dd>
            <input type="submit" value="パスワードを再設定">
            <button type="" name="">送信</button>
          </dd>
        </dl>
      </form>
<?php
// フッター読み込み
include('../common/footer.php');
?>
<?php
// ここにデータベースなどの登録処理などを行う
// env.php を読み込み
include('../vendor/env.php');
// PDO インスタンス作成
try {
  $user =  $_POST['user'];
  $title = $_POST['title'];
  $summary = $_POST['summary'];
  $category = $_POST['category'];

    $dbh = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; chaarset=utf8', DB_USER, DB_PASSWORD);
    $sql = "INSERT INTO novels(user_id,novel_title, summery, category) VALUES (:user, :title, :summary, :category)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':user', $user);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':summary', $summary);
    $stmt->bindValue(':category',$category);
    $stmt->execute();
  } catch (PDOException $e) {
    $msg = $e->getMessage();
    // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
    // exit();
  }

// ヘッダー読み込み
include('../common/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<div class="top_page">
          <!-- <div class="hello indexhello"> -->
            <div class="com_top1">投稿完了<br>Posting completed</div>
            <div class="com_top2"></div>
            <div class="com_top3"></div>
            <div class="com_top4"></div>
            <div class="com_top5"></div>
            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/index.php" class="com_top6">
            Home▶︎
          </a>
            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/mypage.php" class="com_top7" >
            My page▶︎
          </a>
            <div class="com_top8"></div>
 </div>
</body>
</html>
<?php
// フッター読み込み
include('../common/footer.php');
?>

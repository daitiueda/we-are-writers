<?php
// ここにデータベースなどの登録処理などを行う
// env.php を読み込み
include('../vendor/env.php');
// PDO インスタンス作成

  $title =  $_POST['title'];
  $body = nl2br($_POST['body'] ?? '' );
  $novel = $_POST['novel'];
try{
  $dbh = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; chaarset=utf8', DB_USER, DB_PASSWORD);
}catch (PDOException $e) {
  $msg = $e->getMessage();
}
    
    $sql = "SELECT * from novel_chapters where novel_id = :novel_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':novel_id',$novel);
    $stmt->execute();
    $chapter_count = $stmt->rowCount();
    $chapter_number = $chapter_count + 1;

    $dbh = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; chaarset=utf8', DB_USER, DB_PASSWORD);
    $sql = "INSERT INTO novel_chapters(novel_id, chapter_title, chapter_number, body, create_at, update_at) VALUES (:novel_id, :chapter_title, :chapter_number, :body, :create_at, :update_at)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':novel_id', $novel);
    $stmt->bindValue(':chapter_title', $title);
    $stmt->bindValue(':chapter_number', $chapter_number);
    $stmt->bindValue(':body', $body);
    $stmt->bindValue(':create_at', date('Y-m-d H:i:s'));
    $stmt->bindValue(':update_at', date('Y-m-d H:i:s'));
    $stmt->execute();

// ヘッダー読み込み
include('../common/header.php');
?>
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

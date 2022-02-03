<?php
// env.php を読み込み
include('../vendor/env.php');

// コメントが投稿されたときの処理

// PDO インスタンス作成
try {
    $dbh = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; chaarset=utf8', DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
    $msg = $e->getMessage();
    echo '<div>エラーが発生しました。読み込みなおしてください。</div>';
    exit();
}
    $search = $_GET['search'];
// 値が存在すれば投稿処理を行う
 $keyword =  '%'.$search.'%';
  $sql = "SELECT * FROM novels WHERE novel_title LIKE :keyword OR category LIKE :keyword;";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':keyword', $keyword);
  $stmt->execute();
  $novels = $stmt->fetchAll();
  if($novels === [] ){
    echo '<h1> NOT FOUND</h1>';
  }
?>
<?php foreach($novels as $novel){ ?>
  <?php
        $novel_id = $novel["user_id"];
        $sql="SELECT * FROM users WHERE id = $novel_id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetch();
   ?>
        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/novel/novel_summery.php?novel_id=<?= $novel["id"] ?>" class="nav_button">
        <div class="novel">
        <p><div class="cool">Title</div><?= $novel['novel_title'] ?></p>
          <p><div class="cool">Category</div><?= $novel['category'] ?></p>
          <p><div class="cool">Writer</div><?= $user['name'] ?? '' ?></p>
          <!-- <?php if($isAdmin) { ?><button onclick="deleteNovel('<?= $novel['id'] ?>');">削除</button><?php } ?> -->
          </div>
          </a>
<?php } ?>
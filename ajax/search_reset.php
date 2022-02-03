<?php 
// env.php を読み込み
include('../vendor/env.php');

if (session_status() == PHP_SESSION_NONE) {
  // セッションは有効で、開始していないとき
  session_start();
}

// PDO インスタンス作成
try {
  $dbh = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; chaarset=utf8', DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
  $msg = $e->getMessage();
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}

// 管理者かどうか判断
$isAdmin = false;
if (isset($_SESSION['user']) && $_SESSION['user'] !== []) {
  $sql = "SELECT * FROM users WHERE id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':id', $_SESSION['user']['id']);
  $stmt->execute();
  $user = $stmt->fetch();

  if ($user['user_type'] === 2) {
    $isAdmin = true;
  }
}


// novelsテーブルの一覧を取得
$limit = 20; 
if(!isset($_GET['page']) || !is_int($_GET['page'])) {
  $_GET['page'] = 1;
}
$startLine = $limit * (($_GET['page'] ?? 1) -1);
$sql = "SELECT * FROM novels ORDER BY id LIMIT {$limit} OFFSET {$startLine}";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$novels = $stmt->fetchAll();
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
          <p><div class="cool">Writer</div><?= $users['name'] ?? '不明'?></p>
          <?php if($isAdmin) { ?><button onclick="deleteNovel('<?= $novel['id'] ?>');">削除</button><?php } ?>
        </div>
        </a>
<?php } ?>
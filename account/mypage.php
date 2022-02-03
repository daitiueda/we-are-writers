<?php
// env.php を読み込み
include('../vendor/env.php');

if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}

// ログイン状態でなければログインページにリダイレクト
if (!isset($_SESSION['user']) || $_SESSION['user'] === []) {
    include('../vendor/auth.php');
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location:http://{$_SERVER['HTTP_HOST']}/account/login.php");
    exit();
}

// PDO インスタンス作成
try {
    $dbh = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; chaarset=utf8', DB_USER, DB_PASSWORD);
  } catch (PDOException $e) {
    $msg = $e->getMessage();
    // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
    // exit();
  }


// お気に入り登録したnovelsテーブルの一覧を取得
$limit = 20; 
if(!isset($_GET['page']) || !is_int($_GET['page'])) {
  $_GET['page'] = 1;
}

$startLine = $limit * (($_GET['page'] ?? 1) -1);
$login = $_SESSION['user']['id'];

$sql = "SELECT * FROM user_favorites WHERE user_id = $login";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$favorites = $stmt->fetchAll();

$favorite_novel_ids = [];
foreach($favorites as $favorite ){
  $favorite_novel_ids[] = $favorite['novel_id'];
}
$novel_ids_text = implode(', ', $favorite_novel_ids);
// var_dump($novel_ids_text);
// exit();

if($novel_ids_text !== ''){
    $sql = "SELECT * FROM novels WHERE id IN ({$novel_ids_text}) ORDER BY id LIMIT {$limit} OFFSET {$startLine}";
    // $sql = "SELECT user_favorites.novel_id FROM user_favorites WHERE user_id = :user_id LEFT JOIN novels ON user_favorites.novel_id = novels.id;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $favorite_novels = $stmt->fetchAll();
    // var_dump($favorite_novels);
    // exit();
}else{
  $favorite_novels = [];
}
$sql = "SELECT * FROM novels WHERE user_id = $login ORDER BY id LIMIT {$limit} OFFSET {$startLine}";
// $sql = "SELECT user_favorites.novel_id FROM user_favorites WHERE user_id = :user_id LEFT JOIN novels ON user_favorites.novel_id = novels.id;";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':user_id', ($_SESSION['user']['id'] ?? 0));
$stmt->execute();
$create_novels = $stmt->fetchAll();

$max_page = floor(count($create_novels) / 20);

// ヘッダー読み込み
include('../common/header.php');
?>

<div class="top_page">
          <!-- <div class="hello indexhello"> -->
            <div class="sub_top1"></div>
            <div class="sub_top2">My page</div>
            <div class="sub_top3"></div>
            <div class="sub_top4">このページではお気に入り登録した小説の閲覧や<br>小説の新規作成ができます</div>
            <div class="sub_top5"></div>
            <div class="sub_top6"></div>
            <div class="sub_top7"></div>
            <div class="sub_top8"></div>
            <div class="sub_top9">HELLO!!<br><secssion class="user_name">"<?= $_SESSION['user']['name']?>"</secssion></div>
 </div>

<div class="page_title">My Novels</div>
<div class="page">

<div class="page_heading" >
  新規小説の投稿、あなたが作成した小説を閲覧することができます
</div>


  <div class="novels">

  <form action="http://<?= $_SERVER['HTTP_HOST']?>/novel/novel_post.php" method = "post">
    <input type="hidden" name="user" value="<?= $_SESSION['user']['id']?>">
    <button class="novel_new" type="submit"><div class="plus">＋</div><br>Create new novel!</button>
   </form>
       <?php foreach($create_novels as $novel){ ?>
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
          <form action="http://<?= $_SERVER['HTTP_HOST']?>/novel/novel_edit.php" method = "post">
            <input type="hidden" name="novel" value="<?= $novel["id"] ?>">
            <input type="submit" class="new_chapter" value="+">
            </form>
          <?php if($isAdmin) { ?><button onclick="deleteNovel('<?= $novel['id'] ?>');">削除</button><?php } ?>
          </div>
          </a>
<?php } ?>
</div>
</div>

<div class="page_title">Favorite Novels</div>
<div class="page">
<div class="page_heading" >
  お気に入り登録した小説を読むことができます
</div>
  <div class="novels">
<?php if($favorite_novel_ids === []) { ?>
  <h1>Not Found</h1>
<?php } else { ?>
       <?php foreach($favorite_novels as $novel){ ?>
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
          <p><div class="cool">Writer</div><?= $users['name'] ?? '不明' ?></p>
          <!-- <form action="http://<?= $_SERVER['HTTP_HOST']?>/novel/novel_edit.php" method = "post">
            <input type="hidden" name="novel" value="<?= $novel["id"] ?>">
            <input type="submit" value="最新話作成">
            </form> -->
          <?php if($isAdmin) { ?><button onclick="deleteNovel('<?= $novel['id'] ?>');">削除</button><?php } ?>
          </div>
          </a>
          <?php } ?>
<?php } ?>
</div>
<div class="foot"></div>
</div>
<?php
// フッター読み込み
include('../common/footer.php');
?>
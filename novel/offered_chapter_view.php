<?php 
// env.php を読み込み
include('../vendor/env.php');

if (session_status() == PHP_SESSION_NONE) {
  // セッションは有効で、開始していないとき
  session_start();
}

if (!isset($_GET['novel_id']) || !isset($_GET['chapter_id'])) {
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}

try {
  $dbh = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; chaarset=utf8', DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
  $msg = $e->getMessage();
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}

// 管理者かどうか判断
$isAdmin = false;
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $_GET['user_id']);
$stmt->execute();
$user = $stmt->fetch();

if ($user !== false) {
    if ($user['user_type'] === 2) {
        $isAdmin = true;
    }
}
$novel_id = $_GET['novel_id'] ?? 0;

// 小説概要を取得
$sql = "SELECT * FROM novels WHERE id = :novel_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':novel_id', $novel_id);
$stmt->execute();
$novel = $stmt->fetch();


// 小説本文を取得
$sql = "SELECT * FROM novel_chapters WHERE id = :novel_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':novel_id', $novel_id);
$stmt->execute();
$chapters = $stmt->fetchAll();


// 募集中の小説を取得
$sql = "SELECT * FROM offered_chapters WHERE novel_id = :novel_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $novel_id);
$stmt->execute();
$offered_chapters = $stmt->fetchAll();


// 存在しなければリダイレクト
if ($novel === false || $offered_chapters === false) {
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}

// ヘッダー読み込み
include('../common/header.php');
?>

<!-- 小説本文 -->
<h1>小説本文</h1>
<?php if($offered_chapters !== false) { ?>
    
    <p>title</p>
    <p><?= $novel['novel_title'] ?? '' ?></p>
    <p><?= '' ?>さんが投稿した第<?= (count($chapters) + 1) ?>話</p>
    <p><?= $chapter['chapter_title'] ?></p>
<?php } else { ?>
    <!-- 投稿された小説が一軒もなかった場合 -->
    <p>現在、この小説の最新話はまだ投稿されていません</p>
<?php } ?>

<div><?= $chapter['body'] ?></div>

<!-- コメント欄 -->
<div>
    <div id="ajax_comments">
        <?php foreach($chapter_comments as $chapter_comment) { ?>
        <div>
            <p><?= $chapter_comment['comment_datetime'] ?></p>
            <p><?= $chapter_comment['comment_name'] ?></p>
            <p><?= $chapter_comment['comment'] ?></p>
            <!-- 管理者にしか出てこないボタン -->
            <?php if($isAdmin) { ?><button onclick="deleteComment(<? $chapter_comment['id'] ?>);"></button><?php } ?>
        </div>
        <?php } ?>
    </div>
    <div>
        <p>コメント投稿</p> 
        <p>投稿名：</p><input type="text" name="" id="comment_name">
        <textarea name="" id="comment_textarea" cols="30" rows="10"></textarea>
        <button id="ajax_comment_button">投稿する</button>
    </div>
</div>

<!-- 概要 -->
<p>overview</p>
<p><?= $novel['summery'] ?></p>

<?php foreach($chapters as $chapter) { ?>
<p>第<?= $chapter['chapter_number'] ?>話</p>
<a href="http://<?= $_SERVER['HTTP_HOST'] ?>/novel/chapter_view.php?novel_id=<?= $_GET['novel_id'] ?>&chapter_id=<?= $chapter['id'] ?>">読む！</a>
<?php } ?>
<?php
// フッター読み込み
include('../common/footer.php');
?>
<?php
// env.php を読み込み
include('./vendor/env.php');

// 管理者によりコメントが削除されたときの処理

// PDO インスタンス作成
try {
    $dbh = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; chaarset=utf8', DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
    $msg = $e->getMessage();
    echo '<div>エラーが発生しました。読み込みなおしてください。</div>';
    exit();
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

// 管理者であれば削除実行
if ($isAdmin) {
    $sql = "DELETE FROM chapter_comments WHERE id = :chapter_comment_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':chapter_comment_id', ($_GET['chapter_comment_id'] ?? 0));
    $stmt->execute();
}

// コメントを再取得
$sql = "SELECT * FROM chapter_comments WHERE id = :chapter_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':chapter_id', $_GET['chapter_id']);
$stmt->execute();
$chapter_comments = $stmt->fetchAll();
?>
<?php foreach($chapter_comments as $chapter_comment) { ?>
    <div>
        <p><?= $chapter_comment['comment_datetime'] ?></p>
        <p><?= $chapter_comment['comment_name'] ?></p>
        <p><?= $chapter_comment['comment'] ?></p>
        <!-- 管理者にしか出てこないボタン -->
        <?php if($isAdmin) { ?><button onclick="deleteComment(<? $chapter_comment['id'] ?>);"></button><?php } ?>
    </div>
<?php } ?>
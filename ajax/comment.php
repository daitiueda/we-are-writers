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

    // echo $_GET['comment']."<br>";
    // echo $_GET['chapter_id']."<br>";
    // echo $_GET['comment_name'];

    $comment = $_GET['comment'];
    $comment_name = $_GET['comment_name'] ?? '';
    $chapter_id= $_GET['chapter_id'];

    if($comment_name == null){
        $comment_name = '通りすがりの佐々木';
    }

// 値が存在すれば投稿処理を行う
if (isset($comment) && $comment !== '') {
    $sql = "INSERT INTO chapter_comments(chapter_id,comment_name, comment, comment_datetime) VALUES (:chapter_id, :comment_name, :comment, :comment_datetime)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':chapter_id', $chapter_id);
    $stmt->bindValue(':comment_name', $comment_name);
    $stmt->bindValue(':comment', $comment);
    $stmt->bindValue(':comment_datetime',date('Y-m-d H:i:s'));
    $stmt->execute();
}
// コメントを再取得
$sql = "SELECT * FROM chapter_comments WHERE chapter_id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $chapter_id);
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
        <div>------------------------------------------------------</div>
    </div>
<?php } ?>



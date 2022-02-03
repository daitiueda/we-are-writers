<?php
// env.php を読み込み
include('./vendor/env.php');

// 管理者により小説が削除されたときの処理

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
    $sql = "DELETE FROM novels WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', ($_GET['id'] ?? 0));
    $stmt->execute();
}

// novelsテーブルの一覧を再取得
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
<tr>
    <td><?= $novel['novel_title'] ?></td>
    <td><?= $novel['category'] ?></td>
    <td><?= $novel['user_id'] ?></td>
    <td><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/novel/novel_summery.php?novel_id=<?= $novel["id"] ?>">読む！</a></td>
    <td><?php if($isAdmin) { ?><button onclick="deleteNovel('<?= $novel['id'] ?>');">削除</button><?php } ?></td>
</tr>
<?php } ?>
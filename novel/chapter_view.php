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
// $isAdmin = false;
// $sql = "SELECT * FROM users WHERE id = :id";
// $stmt = $dbh->prepare($sql);
// $stmt->bindValue(':id', $_GET['user_id']);
// $stmt->execute();
// $user = $stmt->fetch();

// if ($user !== false) {
//     if ($user['user_type'] === 2) {
//         $isAdmin = true;
//     }
// }

// 小説概要を取得
$sql = "SELECT * FROM novels WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $_GET['novel_id']);
$stmt->execute();
$novel = $stmt->fetch();


// 小説本文を取得
$sql = "SELECT * FROM novel_chapters WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $_GET['chapter_id']);
$stmt->execute();
$chapter = $stmt->fetch();


// コメントを取得
$sql = "SELECT * FROM chapter_comments WHERE chapter_id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $_GET['chapter_id']);
$stmt->execute();
$chapter_comments = $stmt->fetchAll();



// 存在しなければリダイレクト
if ($novel === false || $chapter === false) {
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}

// ヘッダー読み込み
include('../common/header.php');
?>

<!-- 小説本文 -->
<div class="view">
<div class="one_chapter_novel_title"><?= $novel['novel_title'] ?? '' ?></div>
<div class="one_chapter_number">#<?= $chapter['chapter_number'] ?></div>
<div class="one_chapter_title"><?= $chapter['chapter_title'] ?></div>
<div class="one_chapter"><?= nl2br($chapter['body'] ?? "") ?></div>
<!-- <p>writen by "<?= $chapter['writer'] ?>"</p> -->
<div class="comments">
    <div id="ajax_comments">
      <h1>コメント投稿</h1>
        <?php foreach($chapter_comments as $chapter_comment) { ?>
        <div class ="comment">
          <p><?= $chapter_comment['comment_name'] ?></p>
          <p><?= $chapter_comment['comment'] ?></p>
          <p><?= $chapter_comment['comment_datetime'] ?></p>
            <!-- 管理者にしか出てこないボタン -->
            <!-- <?php if($isAdmin) { ?><button onclick="deleteComment(<? $chapter_comment['id'] ?>);"></button><?php } ?> -->
            <div>------------------------------------------------------</div>
        </div>
        <?php } ?>
    </div>
    
    <div>
        <p><input type="text" name="name" id="comment_name"placeholder="通りすがりの佐々木" ></p>
        <textarea name="comment" id="comment_textarea" cols="30" rows="10" placeholder="コメント"></textarea>
        <p><button id="ajax_comment_button">投稿する</button></p>
    </div>
</div>
<div id="ajax_test"></div>

</div>

<!-- コメント欄 -->

<!-- 概要 -->
<!-- <p>overview</p>
<p><?= $novel['summery'] ?></p> -->

<!-- <?php foreach($chapters as $chapter) { ?>
<p>第<?= $chapter['chapter_number'] ?>話</p>
<a href="http://<?= $_SERVER['HTTP_HOST'] ?>/novel/chapter_view.php?novel_id=<?= $_GET['novel_id'] ?>&chapter_id=<?= $chapter['id'] ?>">読む！</a>
<?php } ?> -->

<script>
    $('#ajax_comment_button').on('click', function() {
        comment_name = $('#comment_name').val() ?? '';
        comment = $('#comment_textarea').val() ?? '';
        // ajaxで通信して登録・解除する命令を送信
        $.ajax({
          type: 'GET',
          url: 'http://<?= $_SERVER['HTTP_HOST'] ?>/ajax/comment.php',
          data: { 
            comment_name: comment_name,
            comment: comment,
            chapter_id: <?= $_GET['chapter_id']?>
          },
          dataType: 'html'
        })
        .done(function(data) {
          $('#ajax_comments').empty();
            $('#ajax_comments').html(data);
            // $('#ajax_test').html(data);
        })
        .fail(function() {
            // 登録・解除失敗時には、その旨をダイアログ表示
            alert('投稿に失敗しました。');
        });
    });

    // 管理者用のコメント削除ボタンのファンクション
    function deleteComment(chapter_comment_id) {
      isDelete = confirm('このコメントを削除します。本当によろしいですか？');
      if (!isDelete) {
        return;
      }
      // ajaxで通信して削除する命令を送信
      $.ajax({
          type: 'GET',
          url: 'http://<?= $_SERVER['HTTP_HOST'] ?>/ajax/comment_delete.php',
          data: { 
            user_id: <?= $user['id'] ?? 0 ?>,
            order: 'delete',
            table: 'chapter_comment',
            column: 'id',
            id: chapter_comment_id,
          },
          dataType: 'html'
      })
      .done(function(data) {
        // 元のコメント欄をクリアして、新しいhtmlを挿入
        $('#ajax_test').html(data);
        $('#ajax_comments').empty();
        $('#ajax_comments').html(data);
        alert('削除が完了しました');
      })
      .fail(function() {
        // 削除失敗時には、その旨をダイアログ表示
        alert('削除に失敗しました。');
      });
    }
</script>
<?php
// フッター読み込み
include('../common/footer.php');
?>
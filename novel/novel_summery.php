<?php 
// env.php を読み込み
include('../vendor/env.php');

if (session_status() == PHP_SESSION_NONE) {
  // セッションは有効で、開始していないとき
  session_start();
}

if (!isset($_GET['novel_id'])) {
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

// 小説概要を取得
$sql = "SELECT * FROM novels WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $_GET['novel_id']);
$stmt->execute();
$novel = $stmt->fetch();

if ($novel === false) {
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}
// ログインid取得

$login_user = false;
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $_SESSION['user']['id'] ?? 0);
$stmt->execute();
$user = $stmt->fetch();


if ($novel === false) {
  // header("Location:http://{$_SERVER['HTTP_HOST']}/404.php");
  // exit();
}

// chapter 一覧を取得
$sql = "SELECT * FROM novel_chapters WHERE novel_id = :novel_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':novel_id', $_GET['novel_id']);
$stmt->execute();
$chapters = $stmt->fetchAll();

if ($chapters === false) {
  $chapters = [];
} 

// if ($novel['last_chapter'] > count($chapters)) {

// }

// お気に入り確認
function check_favorite($user_id,$novel_id){
  $dsn='mysql:dbname=db_local;host=localhost;charset=utf8';
  $user='root';
  $password='root';
  $dbh=new PDO($dsn,$user,$password);
  $sql = "SELECT * FROM user_favorites WHERE user_id = :user_id AND novel_id = :novel_id";
  // $sql = "SELECT * FROM user_favorites WHERE user_id = :user_id AND novel_id = :novel_id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':user_id', $user_id);
  $stmt->bindValue(':novel_id', $novel_id);
  // $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $favorite = $stmt->fetch();
  return $favorite;
}
// array(':user_id' => $user_id ,':nvoel_id' => $novel_id)
// ヘッダー読み込み
include('../common/header.php');
?>
<div class="summary">
<div class="one_novel_title"><?= $novel['novel_title'] ?? '' ?></div>
<div class="one_novel_over">OVERVIEW</div>
<div class="one_novel_summary"><?= nl2br($novel['summery'] ?? '') ?></div>

<?php foreach($chapters as $chapter) { ?>
<div class="chapter_number">Capter#<?= $chapter['chapter_number'] ?></div>
<a href="http://<?= $_SERVER['HTTP_HOST'] ?>/novel/chapter_view.php?novel_id=<?= $_GET['novel_id'] ?>&chapter_id=<?= $chapter['id'] ?>"><div class="chapter_read_button">READ!!</div></a>
<?php } ?>
<!-- <p>テスト１</p>
<p><?php var_dump(check_favorite($_SESSION['user']['id'],$_GET['novel_id']) )?></p>
<p>テスト2</p>
<p><?php var_dump(check_favorite(5,$_GET['novel_id']) )?></p>
<?php if ($novel['last_chapter'] > count($chapters)) { ?> -->
    <div>
      <!-- 投稿受付中のチャプター -->
      <p>第<?= (count($chapters) + 1) ?>話</p>
      <p>投稿・投票受付中！</p>
      <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/novel/offered_chapter_view.php?novel_id=<?= $_GET['novel_id'] ?>">読む！</a>
    </div>
<?php } ?>
<!-- お気に入り -->
        <?php if (isset($_SESSION['user']) || $_SESSION['user'] === []) { ?>
          <button type="button"  id="ajax_favorite_btn"><?php if (!is_array(check_favorite($_SESSION['user']['id'],$_GET['novel_id'] ) ) ): ?><div class="unfavorite_button"><p>Favorite</p></div><?php else: ?><div class="favorite_button"><p>Favorite</p></div><?php endif; ?></button>
       <?php } ?>
</div>

<script>

  // お気に入り登録・解除のファンクション
  $('#ajax_favorite_btn').on('click', function() {
    const regist = 'Favorite';
    const kaijo = 'Unfavorite';
    let order;
    console.log('ajax_start');
    if($('#ajax_favorite_btn').text() != regist){
      order = regist;
    }else{
      order = kaijo;
    }
        // comment_name = $('#comment_name').val() ?? '';
        // comment = $('#comment_textarea').val() ?? '';
        // ajaxで通信して登録・解除する命令を送信
        $.ajax({
          type: 'GET',
          url: 'http://<?= $_SERVER['HTTP_HOST'] ?>/ajax/favorite.php',
          data: { 
            order: order,
            table: 'user_favorites',
            user_id: <?= $_SESSION['user']['id'] ?? 0 ?>,
            novel_id: <?= $_GET['novel_id'] ?>,
          },
          dataType: 'html'
        })
        .done(function(data) {
            // ボタンのテキストを変更
            // console.log('ajax_done');
            // $('#ajax_test').html(data);
            // $('#ajax_favorite_btn').text(order);
            $('#ajax_favorite_btn').empty();
          $('#ajax_favorite_btn').html(data);
        })
        .fail(function() {
            // 登録・解除失敗時には、その旨をダイアログ表示
            console.log('ajax_fail');
            alert(order + 'に失敗しました。');
        });
    });


</script>

<?php
// フッター読み込み
include('../common/footer.php');
?>
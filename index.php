<?php 
// env.php を読み込み
include('./vendor/env.php');

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
// var_dump($novels);
// die;
$max_page = floor(count($novels) / 20);

// このページのタイトルを設定
$title = '小説一覧';
// ヘッダー読み込み
include('./common/header.php');
?>
    <div class="top_page">
          <!-- <div class="hello indexhello"> -->
            <div class="top1">Story <br>drawn <br>by everyone</div>
            <div class="top2">Read Novels⬇️</div>
            <div class="top3"></div>
            <div class="top4">小説投稿サイト</div>
            <div class="top5"></div>
            <div class="top6"></div>
            <div class="top7"></div>
            <div class="top8"></div>
          </div>
    <div class="page">
      <div class="page_title">Novels</div>
      
      <div class="serch_box">
      <form method="post">
          <!-- 任意の<input>要素＝入力欄などを用意する -->
          <input type="text" name="" id="search_value" placeholder="キーワード">
          <!-- 送信ボタンを用意する -->
          <input type="button" name="" id="search_button" value="SEARCH">
          <input type="button" name="" id="search_reset" value="RESET">
       </form>
      </div>
       
      <div class="novels">
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
          <p><div class="cool">Writer</div><?= $users['name'] ?? '不明' ?></p>
          <?php if($isAdmin) { ?><button onclick="deleteNovel('<?= $novel['id'] ?>');">削除</button><?php } ?>
          </div>
          </a>
          <?php } ?>
      </div>

      <div class='paging'>
        <div>- PAGES -</div>
        <?php
        for($i=1;$i<=$max_page+1;$i++) {
          if(($_GET['page'] ?? 1) == $i) {
            echo $i;
          } else {
            echo "<a href='?page=".$i."'>".($i)."</a>";
          }
        }
        ?>
      </div>
    </div>
  <script>
    //検索機能
    $('#search_button').on('click', function() {
        search = $('#search_value').val() ?? '';
        // ajaxで通信して登録・解除する命令を送信
        $.ajax({
          type: 'GET',
          url: 'http://<?= $_SERVER['HTTP_HOST'] ?>/ajax/search.php',
          data: { 
            search: search
          },
          dataType: 'html'
        })
        .done(function(data) {
          $('.novels').empty();
          $('.novels').html(data);
        })
        .fail(function() {
            // 登録・解除失敗時には、その旨をダイアログ表示
            alert('検索に失敗しました');
        });
    });

    $('#search_reset').on('click', function() {
      search = $('#search_value').val() ?? '';
        // ajaxで通信して登録・解除する命令を送信
        $.ajax({
          type: 'GET',
          url: 'http://<?= $_SERVER['HTTP_HOST'] ?>/ajax/search_reset.php',
          dataType: 'html'
        })
        .done(function(data) {
          $('.novels').empty();
          $('.novels').html(data);
        })
        .fail(function() {
            // 登録・解除失敗時には、その旨をダイアログ表示
            alert('検索に失敗しました');
        });
    });
    // 管理者の小説削除ボタンのファンクション
    function deleteNovel(novel_id) {
      isDelete = confirm('この小説を削除します。本当によろしいですか？');
      if (!isDelete) {
        return;
      }
      // ajaxで通信して削除する命令を送信
      $.ajax({
          type: 'GET',
          url: 'http://<?= $_SERVER['HTTP_HOST'] ?>/ajax/novel_delete.php',
          data: { 
            user_id: <?= $user['id'] ?? 0 ?>,
            order: 'delete',
            table: 'novels',
            column: 'id',
            id: novel_id,
          },
          dataType: 'html'
      })
      .done(function(data) {
        // 元のtbodyの中身をクリアして、新しいhtmlを挿入
        $('#ajax_tbody').empty();
        $('#ajax_tbody').html(data);
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
include('./common/footer.php');
?>
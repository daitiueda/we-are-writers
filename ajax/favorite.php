<?php 

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

if( !isset($_GET['user_id']) || !isset($_GET['novel_id']) ) {
  echo '<h1>失敗</h1>';
}else{
  $user_id = $_GET['user_id'];
  $novel_id = $_GET['novel_id'];

    if(is_array(check_favorite($user_id,$novel_id) ) ){
      $sql = "DELETE FROM user_favorites WHERE :user_id = user_id AND :novel_id = novel_id";
      ?>
      <div class="unfavorite_button"><p>Favorite</p></div>
      <?php
    }else{
      $sql = "INSERT INTO user_favorites(user_id,novel_id) VALUES(:user_id,:novel_id)";
      ?>
      <div class="favorite_button"><p>Favorite</p></div>
      <?php
    }
  try{
    $dsn='mysql:dbname=db_local;host=localhost;charset=utf8';
    $user='root';
    $password='root';
    $dbh=new PDO($dsn,$user,$password);
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':user_id' => $user_id, ':novel_id' => $novel_id));
  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    set_flash('error',ERR_MSG1);
    echo json_encode("error");
  }
}
  // 登録または登録解除の処理（db）
// echo $_GET['order'].$_GET['table'].$_GET['user_id'].$_GET['novel_id'];
//   echo '<h1>成功</h1>';
?>
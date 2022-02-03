<?php
// ここでバリデーションの処理を行う
session_start();

//以下バリデーション処理
$_SESSION['form']['errors'] = [];
if( empty($_POST["demo1"])){
    $_SESSION['form']['errors']['demo1'] = 'demo1は入力必須です';
}
if(empty($_POST["demo2"])){
    $_SESSION['form']['errors']['demo2'] = 'demo2は入力必須です';
}
if(!empty($_POST["demo3"])){
    if(mb_strlen($_POST["demo3"])<10 ){
        $_SESSION['form']['errors']['demo3'] = 'demo3は十文字以上で記入し下さい';
    }
}
// $_SESSION['form']['erorrs']が空でなければリダイレクト
if($_SESSION['form']['errors'] === []){
// 入力値を$_SESSION['form']['input']にセット
    $_SESSION['form']['input']['demo1'] = $_POST['demo1'];
    $_SESSION['form']['input']['demo2'] = $_POST['demo2'];
    $_SESSION['form']['input']['demo3'] = $_POST['demo3'];
    header('Location:base_input.php');
    exit();
}
include('../common/header.php');
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
</head>


<div class="submit_form">

<p>以下の内容で登録しますがよろしいですか？</p>
      <p>Chapter title<br><?php echo $_POST['title'] ?></p>
      <p>Chapter text<br><?php echo $_POST['body'] ?? '' ?></p>
      <input type="hidden" name="user" value="<?=$_POST['user'] ?? '' ?>">
      <form action="http://<?= $_SERVER['HTTP_HOST'] ?>/novel/chapter_complete.php" method="post">
        <input type="hidden" name="title" value="<?= $_POST['title'] ?? '' ?>">
            <input type="hidden" name="body" value="<?= nl2br($_POST['body'] ?? '' ) ?>">
            <input type="hidden" name="novel" value="<?=$_POST['novel'] ?? '' ?>">
            <input type='submit' value ="送信" class="submit_button">
      </form>
      <br>
      <button class="submit_button" onclick="history.back(-1);return false;">戻る</button>
      </div>
      <?php
// フッター読み込み
include('../common/footer.php');
?>
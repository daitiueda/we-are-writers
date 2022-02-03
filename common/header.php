<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/css/base.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/css/header.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/css/footer.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/css/form.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/css/novel.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/css/novel_summary.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/css/novel_view.css">
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/js/jquery-3.6.0.min.js"></script>
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/js/masonry.pkgd.min.js"></script>
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/js/nav.js"></script>
  <!-- <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/asset/js/grid.js"></script> -->
  <title>小説投稿サイト | <?= $title ?? '' ?></title>
  
</head>
<body>
  <div class="header">
      <div class="title" href="http://<?= $_SERVER['HTTP_HOST'] ?>/index.php"><h1>We are writers!</h1></div>
      <div class="nav">
      <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/login.php" class="login">Login</a>
      <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/account_create.php" class="new_account">New account</a>
      <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/account/mypage.php" class="mypage">Mypage</a>
      <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/index.php" class="home">HOME</a>
      </div>
  </div>
  <?= isset($msg) ? '<div class="message_board">'.$msg.'</div>': '' ?>

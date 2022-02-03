
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>コメン斗<td></td></title>
<link rel="stylesheet" href="css/style.css">
</head>
    
<body>
    
<form method="post">            
<p>名前</p>
<input type="text" name="">
<p>コメント</p>
<textarea name="b"></textarea>
<input type="submit" value="送信">
<br><br>
</form>
 
<?php
 if(!empty($_POST["a"]) && !empty($_POST["b"])) {  //POSTが空でなければtrue
  $a = htmlspecialchars($_POST["a"], ENT_QUOTES);
  $b = htmlspecialchars($_POST["b"], ENT_QUOTES);
  $db = new PDO("mysql:host=localhost;dbname=keiji", "root", "");
  $db->query("INSERT INTO chapter_comments (id,name,comment,comment_datetime)
             VALUES (NULL,'$a','$b',NOW())");
  $n = $db -> query("SELECT * FROM chapter_comments ORDER BY no DESC");
  while ($i = $n -> fetch()) {
  print "{$i['id']}: {$i['name']} {$i['comment_datetime']}<br>"
  .nl2br($i['comment'])."<hr>"; 
  }
  } else {                                          //POSTが空の場合の処理
      
  }
  
?>
</body>
 
</html>
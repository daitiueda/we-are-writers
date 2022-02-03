<?php
$errors = [];
$page_flag = 0;
$count = 0;
if (empty($_POST["name"])) {
  $errors[] = "*名前が入力されていません";
  $count++;
}elseif(mb_strlen($_POST["name"]) > 10){
  $errors[] = "*名前は10字以内で入力してください";
  $count++;
}
if($count > 0){
  $errors[] = "*正しく入力をできていない場合は送信できません";
}
if(empty($errors)){
  $page_flag = 1;
}

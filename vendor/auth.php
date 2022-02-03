<?php
// ログインページから呼び出された場合のログイン処理

if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}

if (isset($_POST['email'])) {

    $_SESSION['form'] = [];

    // DB接続
    $dsn = 'mysql:host=localhost; dbname=db_local; charset=utf8';
    $username = 'root';
    $password = 'root';
    try {
        $dbh = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        // $msg = $e->getMessage();
    }

    // 送信された$_POST['email']がDBに存在するかチェック
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $member = $stmt->fetch();

    if($member === false){
        // DBに$_POST['email']が存在しない場合
        $_SESSION['form']['errors'][] = '入力されたメールアドレスのアカウントは存在しません。';
    } else {

        if ($member['user_type'] === 0) {
            // 仮登録のユーザの場合
            $_SESSION['form']['errors'][] = 'このアカウントは仮登録中です。登録したメールアドレスに送信されたリンクをクリックして、本登録操作を完了してください。';
        } else {
            //指定したハッシュがパスワードにマッチしているかチェック
            if (password_verify($_POST['password'], $member['password'])) {
                //DBのユーザー情報をセッションに保存
                $_SESSION['user']['id'] = $member['id'];
                $_SESSION['user']['name'] = $member['name'];
                // セッションに保存したログイン後のリダイレクト先を削除
                $_SESSION['redirect_url'] = '';
            } else {
                $_SESSION['form']['errors'][] = 'メールアドレスもしくはパスワードが間違っています。';
            }
        }
    }
}
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>
<?php

// バリデーション
include('../validation/account.php');

// ヘッダー読み込み
include('../common/header.php');
?>
    <p>「作成」を押すと、以下の内容で仮登録が完了します。</p>
    <p>（仮登録完了後に、本登録用フォームへのリンクがお使いのメールアドレスに送信されます。そのリンクをクリックして、本登録操作を行ってください。）</p>
    <table>
        <thead>
            <tr>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>パスワード</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $_POST['name'] ?? '' ?></td>
                <td><?= $_POST['email'] ?? '' ?></td>
                <td>※非表示</td>
            </tr>
        </tbody>
    </table>
    <form action="http://<?= $_SERVER['HTTP_HOST'] ?>/account/account_complete.php" method="post">
        <input type="hidden" name="name" value="<?= $_POST['name'] ?? '' ?>">
        <input type="hidden" name="email" value="<?= $_POST['email'] ?? '' ?>">
        <input type="hidden" name="password" value="<?= $_POST['password'] ?? '' ?>">
        <input type="hidden" name="password_confirm" value="<?= $_POST['password_confirm'] ?? '' ?>">

        <input type='submit' value ='作成'>
    </form>
    <button onclick="history.back(-1);return false;">修正</button>
<?php
// フッター読み込み
include('../common/footer.php');
?>
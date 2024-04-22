<?php
session_start();
error_reporting(E_ALL); 
ini_set('display_errors', '1');

//※htdocsと同じ階層に「includes」を作成してfuncs.phpを入れましょう！
//include "../../includes/funcs.php";
include "funcs.php"
?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<html lang="ja">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="style.css" />
</head>
<body>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<form name="form1" action="login_act.php" method="post">
<fieldset>
<legend>ログイン画面</legend>
<?php
    if (isset($_SESSION['name'])) {
        $name = $_SESSION['name'];
    } else {
        $name = 'ゲスト';
    }
    echo $name . 'さん、こんにちは！<br>';
    echo "登録したユーザーID,パスワードを入力してください。";
    ?> 
    <br>
ユーザーID:<input type="email" name="username">

<br>
パスワード:<input type="password" name="password">
<input type="submit" value="ログイン">
</form>
<a href="user.php" class="navbar-brand">初回登録の方はこちら</a>
<a href="forgot_password.php" class="navbar-brand">パスワードを忘れた方はこちら</a>
</body>
</html>
</fieldset>


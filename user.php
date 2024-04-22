<?php
session_start();
include "funcs.php";
$pdo = db_conn();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  

  <title>USERデータ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- <style>div{padding: 10px;font-size:16px;}</style> -->
  <link rel="stylesheet" href="style.css" />

</head>
<body>

<!-- <header>
    <?php echo $_SESSION["name"]; ?>さん　 -->
<!-- </header> --> 

<!-- Main[Start] -->
<form method="post" action="user_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ユーザー登録</legend>
    <?php
    if (isset($_SESSION['name'])) {
        $name = $_SESSION['name'];
    } else {
        $name = 'ゲスト';
    }
    echo $name . 'さん、こんにちは！<br>こちらからご登録をお願いいたします';
    ?>
     <label>名前<input type="text" name="name" required></label><br>
     <label>ユーザーID: メールアドレスを入力<input type="email" name="username" required></label><br>
     <label>パスワード: 6桁以上の英数字<input type="password" name="password" minlength="6" required></label><br>
     <label>登録区分：
      無料<input type="radio" name="kanri_flg" value="0" required>　
      有料<input type="radio" name="kanri_flg" value="1" required>
    </label><br>
     <!-- <label>退会FLG：<input type="text" name="life_flg"></label><br> -->
     <input type="submit" value="送信">
     <a href="login.php" class="navbar-brand">ログインの方はこちら</a>
     <a href="https://sand-stoplight-837.notion.site/4319976cc82f406fa8cf2075cde67124" class="navbar-brand">利用規約</a>
     <a href="https://sand-stoplight-837.notion.site/14c3832cc5ab4b7094093a1d53684e47" class="navbar-brand">プライバシーポリシー</a>
  </div>
</form>



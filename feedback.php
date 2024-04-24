<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ストーリー登録完了</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>お疲れ様でした！</h1>
    <p><?= htmlspecialchars($_SESSION['nickname']) ?>のエピソードを書いたんだね！すごいよ！</p>
    <a href="home.php" class="btn btn-primary">ホームに戻る</a>
</div>
</body>
</html>

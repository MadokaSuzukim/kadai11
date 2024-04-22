<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!isset($_SESSION['parent_id'])) {
    // セッションに親のIDがない場合はログインページにリダイレクト
    header('Location: login.php');
    exit;
}

// ニックネームをセッションから取得
$nickname = $_SESSION['nickname'] ?? '登録者';  // ニックネームが未設定の場合のデフォルト値
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>登録完了</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<main>
  <div class="container">
    <h1>登録が完了しました！</h1>
    <?php
      if (isset($_SESSION['name'])) {
          $name = $_SESSION['name'];
          echo "<p>" . htmlspecialchars($name) . "さん、こんにちは！</p>";
      } else {
          echo "<p>ゲストさん、こんにちは！</p>";
      }
      echo "<p>" . htmlspecialchars($nickname) . "ちゃんの情報を登録しました。</p>";
    ?>
    <a href="home.php" class="navbar-brand">ホームへ戻る</a>
  </div>
</main>
</body>
</html>

<!-- menu.php -->
<?php
session_start();
include("funcs.php");
$pdo = db_conn();
?>

    <link rel="stylesheet" href="style.css" />



<nav class="navbar fixed-bottom navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- ブランドとトグルボタン -->
    <a class="navbar-brand" href="#">設定</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- ナビゲーションリンク -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">お子様登録画面</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">ログアウト</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php
session_start();
include("funcs.php");

if (!isset($_SESSION['parent_id'])) {
    header('Location: login.php'); // セッションがない場合はログインページへリダイレクト
    exit;
}

$pdo = db_conn();
$child_id = $_GET['child_id'] ?? null;

if (!$child_id) {
    echo "子供のIDが指定されていません。";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM children WHERE id = :id");
$stmt->bindValue(':id', $child_id, PDO::PARAM_INT);
$stmt->execute();
$child_info = $stmt->fetch();

// ニックネームをセッションに保存
$_SESSION['nickname'] = $child_info['nickname'];

if (!$child_info) {
    echo "指定された子供の情報が見つかりません。";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>育児日記の入力</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <h1>エピソード入力</h1>
    <h1>今日も育児お疲れ様！</h1>
    <p><?= htmlspecialchars($child_info['nickname']) ?>は、今日どんな様子だった？</p>

    <form method="post" action="dialys.php">
        <input type="hidden" name="child_id" value="<?= $child_id ?>">
        <div class="form-group">
            <label for="date">日付：</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">今日の様子：</label>
            <textarea id="content" name="content" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">送信</button>
    </form>
    <a href="home.php">ホームに戻る</a>
</div>
</body>
</html>



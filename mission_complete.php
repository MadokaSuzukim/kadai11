<?php
// データベース接続情報を含むファイルを読み込む
include "funcs.php";
$pdo = db_conn();

// 完了したミッションのログを取得するSQL文
$sql = "SELECT * FROM mission";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$missionLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>完了したミッション一覧</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>完了したミッション一覧</h1>
    <?php if (!empty($missionLogs)): ?>
        <ul>
            <?php foreach ($missionLogs as $log): ?>
                <li><?= $log['completed_at'] ?>: <?= $log['mission_id'] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>完了したミッションはありません。</p>
    <?php endif; ?>

    <a href="home.php" class="navbar-brand">ホームへ戻る</a>
</body>
</html>


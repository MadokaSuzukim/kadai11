<?php
session_start();
include("funcs.php");
$pdo = db_conn();

// セッションの確認
if (!isset($_SESSION['parent_id'])) {
    header('Location: login.php');
    exit;
}

// child_id の取得
$child_id = $_GET['child_id'] ?? null;

// child_id が指定されていない場合はエラーメッセージを表示して終了
if (!$child_id) {
    echo "子供のIDが指定されていません。";
    exit;
}

// 子供情報の取得
$stmt = $pdo->prepare("SELECT * FROM children WHERE id = :id");
$stmt->bindValue(':id', $child_id, PDO::PARAM_INT);
$stmt->execute();
$child_info = $stmt->fetch();

// 子供情報が見つからない場合はエラーメッセージを表示して終了
if (!$child_info) {
    echo "指定された子供の情報が見つかりません。";
    exit;
}

// ニックネームをセッションに保存
$_SESSION['nickname'] = $child_info['nickname'];

// 子供の日記を取得
$sql = "SELECT * FROM diary WHERE child_id = :child_id ORDER BY date DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $child_id, PDO::PARAM_INT);
$stmt->execute();
$diaries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>日記一覧 - 子供ID: <?= htmlspecialchars($child_id) ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <h1>エピソード一覧</h1>
    <p><?= htmlspecialchars($_SESSION['nickname']) ?>のエピソード</p>
    <a href="children_list.php">子供一覧に戻る</a>
    <?php if ($diaries): ?>
        <ul>
            <?php foreach ($diaries as $diary): ?>
                <li><?= htmlspecialchars($diary['date']) ?>: <?= htmlspecialchars($diary['content']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>この子供には登録されたエピソードがありません。</p>
    <?php endif; ?>
    <a href="home.php">ホームに戻る</a>
</div>
</body>
</html>

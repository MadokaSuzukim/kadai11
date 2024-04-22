<?php
session_start();
include("funcs.php");

// データベース接続
$pdo = db_conn();

// 親IDがセッションに保存されているか確認（ログイン機能が実装されている場合）
if (!isset($_SESSION['parent_id'])) {
    echo "ログインが必要です。";
    header('Location: login.php'); // ログインページへリダイレクト
    exit;
}

// 親IDに基づいて子供のデータをデータベースから取得
$parent_id = $_SESSION['parent_id'];
$sql = "SELECT id, name, birthdate FROM children WHERE parent_id = :parent_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
$stmt->execute();
$children = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>子供一覧</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <h1>子供一覧</h1>
    <?php if ($children): ?>
        <ul>
            <?php foreach ($children as $child): ?>
                <li>
                    <?= htmlspecialchars($child['name']) ?>（<?= htmlspecialchars($child['birthdate']) ?>）
                    - <a href="diary_list.php?child_id=<?= $child['id'] ?>">日記リストを見る</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>登録された子供がありません。</p>
    <?php endif; ?>
    <a href="home.php">ホームに戻る</a>

</div>
</body>
</html>

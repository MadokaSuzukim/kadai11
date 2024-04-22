<?php
session_start();
include("funcs.php");
$pdo = db_conn();

if (!isset($_SESSION['parent_id'])) {
    header('Location: login.php');
    exit;
}

$parent_id = $_SESSION['parent_id'];
$sql = "SELECT * FROM children WHERE parent_id = :parent_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
$stmt->execute();
$children = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホームページ</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<main>
    <div class="container">
        <header>スタンドバイミー</header>
        <h2>おうち療育プログラムの目的</h2>
        <ul>
            <li><a href="#" onclick="toggleDetails('module')">スキルビルディングモジュール</a>
                <div id="module-details" class="hidden">
                日常生活の中で必要とされる様々なスキルを段階的に学べるモジュールを提供します。例えば、買い物をする際の計画立てから、実際の購入、予算管理までを学べるセッションです。
                </div>
            </li>
            <li><a href="#" onclick="toggleDetails('activity')">親子でのアクティビティ</a>: 
                <div id="activity-details" class="hidden">
                親と子が一緒に取り組むアクティビティを通じて、コミュニケーションスキルや問題解決スキルを育てます。これには、具体的な役割分担や目標設定が含まれることが望ましいです。
                </div>
            </li>
            <li><a href="#" onclick="toggleDetails('training')">セルフアドボカシートレーニング</a>
                <div id="training-details" class="hidden">
                自己主張や自己擁護のスキルを特に強調し、子どもたちが自分の意見やニーズを効果的に表現できるようトレーニングします。
                </div>
            </li>
            <li><a href="#" onclick="toggleDetails('feedback')">評価とフィードバック</a>
                <div id="feedback-details" class="hidden">
                各ステージでの達成度を評価し、ポジティブなフィードバックを提供して自己効力感を高めるよう努めます。また、改善点についての具体的なアドバイスも行います。
                </div>
            </li>
        </ul>
        <p><?= htmlspecialchars($_SESSION['name'] ?? 'ゲスト') ?>さん、こんにちは！今日も1日お疲れ様！</p>

        <h3>登録キッズ一覧</h3>
        <?php if (!empty($children)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>名前</th>
                        <th>生年月日</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($children as $child): ?>
                    <tr>
                        <td><?= htmlspecialchars($child['name']) ?></td>
                        <td><?= htmlspecialchars($child['birthdate']) ?></td>
                        <td>
                            <a href="edit_child.php?id=<?= $child['id'] ?>">編集</a>
                            <a href="delete_child.php?id=<?= $child['id'] ?>" onclick="return confirm('本当に削除しますか？');">削除</a>
                            <a href="dialy.php?child_id=<?= $child['id'] ?>">ストーリーを記録</a>
                             <a href="diary_list.php?child_id=<?= $child['id'] ?>">ストーリー一覧</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>子供の情報が登録されていません。</p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary">新規キッズデータ登録</a>
        <a href="count.php" class="btn btn-secondary">お子様登録データ分布参照</a>
         <!-- おうち療育プログラムのボタンを追加 -->
         <?php if (!empty($children)): ?>
            <h2>おうち療育プログラム</h2>
            <form action="mission_select.php" method="post">
                <select name="child_id">
                    <?php foreach ($children as $child): ?>
                        <option value="<?= $child['id'] ?>"><?= htmlspecialchars($child['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">買い物編を始める</button>
                <button type="submit">遊び編を始める</button>
                <button type="submit">工作編を始める</button>
                <button type="submit">おでかけ編を始める</button>
            </form>
        <?php endif; ?>
        <a href="logout.php">ログアウト</a>

    </div>

  
</main>

<script>
    function toggleDetails(moduleId) {
        var details = document.getElementById(moduleId + '-details');
        details.classList.toggle('hidden');
    }
</script>        

</body>
</html>

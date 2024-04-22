<?php
session_start();
include("funcs.php");
$pdo = db_conn();

if (!isset($_SESSION['parent_id'])) {
    header('Location: login.php');
    exit;
}

// カテゴリーとその説明を辞書で管理
$missions = [
    'shopping' => [
        ["description" => "1000円でできるだけ多くのアイテムを購入する", "budget" => 1000, "lesson" => "予算内で計画的に買い物をすることの大切さを学ぶ"],
        ["description" => "果物だけで500円分購入する", "budget" => 500, "lesson" => "健康的な選択を意識する"]
    ],
    'play' => [
        ["description" => "公園で一緒に鬼ごっこをする", "budget" => 0, "lesson" => "運動を通じて健康を促進する"],
        ["description" => "家で映画のマラソンをする", "budget" => 300, "lesson" => "共有の体験を通じて家族の絆を深める"]
    ],
    // 他のカテゴリに対しても同様に追加
];
//     'craft' => 
//         [
//             "description" => "リサイクル材料で小物を作る",
//             "budget" => 200,
//             "lesson" => "特定のカテゴリに焦点を当てて選択するスキルを養う"
//         ],
//         [
//             "description" => "自由研究のための実験セットを作る",
//             "budget" => 1000,
//             "lesson" => "特定のカテゴリに焦点を当てて選択するスキルを養う"
//         ],
//     'outing' => [
//         [
//             "description" => "近くの博物館を訪れる",
//             "budget" => 500,
//             "lesson" => "特定のカテゴリに焦点を当てて選択するスキルを養う"
//         ],
//         [
//             "description" => "地元の祭りに参加する",
//             "budget" => 100,
//             "lesson" => "特定のカテゴリに焦点を当てて選択するスキルを養う"
//         ],
       
//     ]
// ]];

// フォームから送信されたデータを受け取る
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedCategory = $_POST['category']; // 選択されたカテゴリ
    $selectedChildId = $_POST['child_id']; // 選択された子供のID
    $categoryMissions = $missions[$selectedCategory];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ミッション選択</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css" /> -->

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            margin: auto;
            display: none; /* Initially hidden */
        }
    </style>
</head>
<body>
    <h2>ミッションを選択してください</h2>
    <form id="missionForm" action="mission_start.php" method="post">
        <select id="missions" name="missions">
            <?php foreach ($categoryMissions as $mission): ?>
                <option value="<?= htmlspecialchars($mission['description']) ?>">
                    <?= htmlspecialchars($mission['description']) ?> - 予算: <?= htmlspecialchars($mission['budget']) ?>円
                </option>
            <?php endforeach; ?>
        </select>
        <button type="button" onclick="startMission()">ミッション開始</button>

    <?php if (!empty($lesson)): ?>
        <script>alert('ミッションを開始します。\n教訓: <?= addslashes($lesson) ?>');</script>
    <?php endif; ?>

        <button type="button" onclick="stopMission()">ミッション終了</button>
    </form>
    <div id="loading" class="loader"></div>

    <canvas id="gameCanvas" width="800" height="600"></canvas>
    <script src="game.js"></script>

    <script>
        function startMission() {
            document.getElementById('loading').style.display = 'block'; // ローディングアニメーションを表示
        }

        function stopMission() {
            document.getElementById('loading').style.display = 'none'; // ローディングアニメーションを停止
            alert("ミッションが完了しました！おめでとうございます！");
        }
    </script>
    <a href="home.php">ホームに戻る</a>
</body>
</html>

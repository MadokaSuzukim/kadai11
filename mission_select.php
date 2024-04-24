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
    'craft' => [
        ["description" => "リサイクル材料で小物を作る", "budget" => 200, "lesson" => "運動を通じて健康を促進する"],
        ["description" => "自由研究のための実験セットを作る", "budget" => 1000, "lesson" => "共有の体験を通じて家族の絆を深める"]
    ],
    'outing' => [
        ["description" => "近くの博物館を訪れる", "budget" => 500, "lesson" => "運動を通じて健康を促進する"],
        ["description" => "地元の祭りに参加する", "budget" => 100, "lesson" => "共有の体験を通じて家族の絆を深める"]
    ],
    // 他のカテゴリに対しても同様に追加
];

// フォームから送信されたデータを受け取る
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedCategory = $_POST['category']; // 選択されたカテゴリ
    $selectedChildId = $_POST['child_id']; // 選択された子供のID
    $categoryMissions = $missions[$selectedCategory];
}

// ブラウザにミッションオプションを出力するためのコード
if (!empty($categoryMissions)): ?>
    <script>
        var missions = <?php echo json_encode($categoryMissions); ?>;
    </script>
<?php endif;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ミッション選択</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css" /> -->

    <style>
       
        @keyframes grow-and-shrink {
    0%, 100% { transform: scale(1); } /* Original size */
    50% { transform: scale(1.5); } /* Grow to 1.5 times original size */
}

/* Define a new animation */
.circle {
    width: 50px;
    height: 50px;
    background-color: #3498db;
    border-radius: 50%;
    margin: auto;
    animation: grow-and-shrink 2s linear infinite;
    display: none; /* Initially hidden */
}

    </style>
</head>
<!-- 既存のHTMLの残り部分 -->
<body>
    <h2>ミッションを選択してください</h2>
    <form id="missionForm" action="mission_start.php" method="post">
        <select id="missionsSelect" name="missions">
            <?php foreach ($categoryMissions as $index => $mission): ?>
                <option value="<?= $index ?>">
                    <?= htmlspecialchars($mission['description']) ?> - 予算: <?= htmlspecialchars($mission['budget']) ?>円
                </option>
            <?php endforeach; ?>
        </select>
        <div id="circle" class="circle"></div>
        <button type="button" onclick="startMission()">ミッション開始</button>
        <button type="button" onclick="stopMission()">ミッション終了</button>
        <div class="button-group">
<a href="home.php" class="border_btn08"><span>home</span></a>
</div>

    </form>
    <div id="loading" class="loader"></div>

    <!-- ゲームキャンバスとゲームスクリプト -->
    <!-- <canvas id="gameCanvas" width="800" height="600"></canvas>
    <script src="game.js"></script> -->
    <script>
    function startMission() {
        // ミッション開始の処理...
    }

    function stopMission() {
        // ミッション終了の処理...
        startAnimation(); // アニメーションを開始する
    }

    function returnHome() {
        stopAnimation(); // アニメーションを停止する
        window.location.href = 'home.php'; // ホームページに戻る
    }
</script>
    <!-- ミッション開始と停止関数 -->
    <script>
        function startMission() {
            var selectedMissionIndex = document.getElementById('missionsSelect').value;
            var selectedMission = missions[selectedMissionIndex];
            alert('ミッションを開始します。\n教訓: ' + selectedMission.lesson);
            
            document.getElementById('circle').style.display = 'block';
            // ゲームの開始やミッション開始の処理を追加するコードをここに書くことができます
        }

        function stopMission() {
            document.getElementById('circle').style.display = 'none';
            alert("ミッションが完了しました！おめでとうございます！");
        }
    </script>
<!-- <a href="javascript:goBackHome()">ホームに戻る</a> -->

</body>
</html>


<?php
// funcs.php ファイルにデータベース接続関数 db_conn() が含まれていることを想定しています

// ミッションとその説明を辞書で管理
$missions = [
    1 => ["description" => "1000円でできるだけ多くのアイテムを購入する", "budget" => 1000],
    2 => ["description" => "果物だけで500円分購入する", "budget" => 500],
    3 => ["description" => "カレーの具材を購入する", "budget" => 1500],
    4 => ["description" => "ママの好きなお菓子を購入して一緒に食べる", "budget" => 500]
];

// フォームからの入力を処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ユーザーが選択したミッションのIDを取得
    $id = $_POST['id'];
    // 選択されたミッションの詳細を取得
    $selected_mission = $missions[$id];
    // ミッションの説明を取得
    $description = $selected_mission['des'];
    echo "<h2>選択したミッション: " . $description . "</h2>";
    echo "<p>このミッションの予算は " . $selected_mission['budget'] . "円です。</p>";
    // ここで追加のユーザー入力を処理することが可能です
    
    // ミッション完了のログをデータベースに保存する
    saveMissionLog($id, $des);
}

// ミッション完了のログをデータベースに保存する関数
function saveMissionLog($id, $des) {
    include "funcs.php";
    $pdo = db_conn();

    try {
        // SQL文を準備
        $stmt = $pdo->prepare('INSERT INTO mission (id, des, completed_at) VALUES (:id, :des, NOW())');
        // パラメータをバインド
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':des', $des, PDO::PARAM_STR);
        // SQL文を実行
        $stmt->execute();
        
        // データベース接続を切断
        $pdo = null;
        
        // ミッション完了のメッセージを表示
        echo "ミッションが完了しました！おめでとうございます！";
    } catch (PDOException $e) {
        // エラーメッセージを出力
        echo 'データベースエラー: ' . $e->getMessage();
        // スクリプトの実行を停止
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ミッション選択</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>ミッションを選択してください</h1>
    <form action="" method="post">
        <?php
        foreach ($missions as $id => $mission) {
            echo "<input type='radio' name='id' value='$id|" . $mission['description'] . "'> " . $mission['description'] . "<br>";
        }
        ?>
        <button type="submit">ミッション開始</button>
    </form>

    <!-- ボタンをクリックした際のHTML -->
    <button onclick="completeMission()">ミッション完了</button>
    <a href="mission_complete.php" class="navbar-brand">ミッション一覧</a>
    <a href="home.php">ホームに戻る</a>
    <script>
        // ボタンをクリックした際のJavaScript
        function completeMission() {
            // サーバーにミッション完了を通知する処理
            // ここでAjaxリクエストを使ってサーバーに通知を送信します

            // 通知が成功した場合は、ミッション完了のおめでとう通知を表示する
            alert("ミッションが完了しました！おめでとうございます！");
        }
    </script>

</body>
</html>


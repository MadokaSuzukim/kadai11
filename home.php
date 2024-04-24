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
    <title>SBM</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            background-color: #F0F8FF; /* 柔らかな青の背景色 */
            font-family: 'Comic Sans MS', 'Comic Neue', cursive;
        }
        .container {
            background-color: #FFF3E0; /* 柔らかなオレンジの背景色 */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            padding: 20px;
            margin-top: 20px;
        }
        header {
            font-size: 2em;
            color: #FFB6C1; /* 柔らかなピンク色のヘッダー */
            text-align: center;
        }
        .hidden {
            display: none;
        }
        .btn-primary {
            background-color: #FFDAB9; /* ピーチ色のプライマリーボタン */
            border-color: #FFDAB9;
        }
        .btn-secondary {
            background-color: #FFC0CB; /* ピンク色のセカンダリーボタン */
            border-color: #FFC0CB;
        }
        a:hover {
            text-decoration: none;
        }
        table {
            margin-top: 20px;
        }
        th, td {
            text-align: center;
        }
        /* CSS追加部分 */
.button-group {
    display: flex;
    justify-content: center;
    margin-top: 20px; /* ボタンが上の要素から離れるようにマージンを設定 */
}

.button-group a {
    margin: 0 10px; /* ボタン間にスペースを設定 */
}
.border_btn08 {
  position: relative;
  text-decoration: none;
  display: inline-block;
  text-align: center;
  width: 100%;
  max-width: 350px; /* ボタンの最大幅 */
}

.border_btn08::before {
  content: "";
  position: absolute;
  z-index: -1;
  top: 4px;
  left: 4px;
  width: 100%;
  height: 100%;
  -moz-border-radius: 100vh;
  -webkit-border-radius: 100vh;
  border-radius: 100vh;
  background-color: #4D9BC1; /* 後ろの背景色 */
}

.border_btn08 span {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  justify-content: center;
  font-weight: bold; /* 文字の太さ */
  border-radius: 100vh;
  border: solid 1px #4D9BC1; /* 線の色 */
  color: #4D9BC1; /* 文字色 */
  padding: 1em 2em;
  background-color: #FFF; /* 背景色 */
  -moz-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
  -webkit-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
}

/* マウスオーバーした際のデザイン */
.border_btn08:hover span {
  background-color: #FFFF00; /* 背景色 */
  transform: translate(4px, 4px);
  transition: all 0.3s ease-in-out;
}
footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #333; /* ダークな背景色 */
    color: white;
    text-align: center;
    padding: 10px 0;
    border-top: 1px solid #666; /* 上部に線を表示 */
    z-index: 1000;
    display: flex;
    justify-content: center; /* 中央揃え */
    align-items: center; /* アイテムを垂直方向の中央に揃える */
}

.menu-icon {
    display: none;  /* 通常はメニューアイコンを非表示に */
    cursor: pointer;
    padding: 10px;
}

.bar {
    display: block;
    width: 25px;
    height: 3px;
    margin: 5px auto;
    background-color: #fff;
}

.navbar {
    display: flex; /* メニューをフレックスボックスとして扱う */
    width: 100%;
    justify-content: space-evenly; /* 項目間に均等なスペースを配置 */
}

.navbar ul {
    display: flex;  /* リストをフレックスコンテナとして設定 */
    list-style: none;
    padding: 0;
    margin: 0;
    width: 100%; /* ulの幅を親の幅に合わせる */
}

.navbar ul li {
    flex: 1;  /* 各項目が均等なスペースを占める */
    text-align: center;  /* テキストを中央寄せ */
}

.navbar ul li a {
    text-decoration: none;
    color: white;
    display: block;
    padding: 10px;
}



</style>
</head>
<body>
<main>
    <!-- <div class="container"> -->
        <!-- <header>スタンドバイミー</header> -->
        <header>SBM@おうち療育プログラム</header>
        <div id="sbm-section">
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
        </div>
        <p><?= htmlspecialchars($_SESSION['name'] ?? 'ゲスト') ?>さん、こんにちは！今日も1日お疲れ様！</p><p>いけそうやったら今日ミッションやってみる？</p><p>無理やったらいいでー</p>
        <!-- HTML変更部分 -->
        <!-- <h2>おうち療育プログラム</h2> -->
<form id="missionForm" action="mission_select.php" method="post">
    <select name="child_id">
        <?php foreach ($children as $child): ?>
            <option value="<?= $child['id'] ?>"><?= htmlspecialchars($child['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <select name="category">
        <option value="shopping">買い物編</option>
        <option value="play">遊び編</option>
        <option value="craft">工作編</option>
        <option value="outing">おでかけ編</option>
    </select>
    <!-- リンク形式のボタン -->
    <div class="button-group">
        <a href="#" class="border_btn08" onclick="document.getElementById('missionForm').submit();"><span>ミッション開始</span></a>
    </div>
</form>

<script> 
function toggleSBMSection() {
    var sbmSection = document.getElementById('sbm-section');
    sbmSection.style.display = sbmSection.style.display === 'none' ? 'block' : 'none';
}
// 初期状態ではSBMセクションを非表示にする
document.getElementById('sbm-section').style.display = 'none';

</script>

<!-- ボタンのグループ化 -->
<div class="button-group">
<a href="index.html" class="border_btn08"><span>ペアレンツ<br>自己内観</span></a>
<a href="janken.html" class="border_btn08"><span>こどもと一緒に学ぶ</span></a>
<a href="#" id="toggleKidsList" class="border_btn08"><span>ユーザー登録<br>キッズ一覧</span></a><!-- 登録キッズ一覧トリガーボタン -->
</div>
<!-- 登録キッズ一覧テーブル -->
<table class="table" id="kidsList" style="display: none;">
    <!-- テーブルヘッダーなど -->
    <tbody>
    <?php if (!empty($children)): ?>
        <?php foreach ($children as $child): ?>
        <tr>
            <td><?= htmlspecialchars($child['name']) ?></td>
            <td><?= htmlspecialchars($child['birthdate']) ?></td>
            <td id="operations-<?= $child['id'] ?>" style="display: none;">
                <a href="edit_child.php?id=<?= $child['id'] ?>">編集</a> |
                <a href="delete_child.php?id=<?= $child['id'] ?>" onclick="return confirm('本当に削除しますか？');">削除</a> |
                <a href="diary.php?child_id=<?= $child['id'] ?>">エピソードを記録</a> |
                <a href="diary_list.php?child_id=<?= $child['id'] ?>">エピソード一覧</a> |
                <a href="mission_complete.php?child_id=<?= $child['id'] ?>">完了ミッション</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">子供の情報が登録されていません。</td>
        </tr>
    <?php endif; ?>
</tbody>
</table>
                <?php if (!empty($children)): ?>
          
        <?php endif; ?>
        <div class="button-group">
<a href="home.php" class="border_btn08"><span>home</span></a>
</div>
<footer onclick="toggleMenu()">
    <!-- ハンバーガーメニューアイコン -->
    <div class="menu-icon" id="menu-icon">
        <div class="bar"></div>
        <div the="bar"></div>
        <div class="bar"></div>
    </div>

    <!-- ナビゲーションリンク -->
    <nav class="navbar" id="navbar">
    <ul>
    <li><a href="index.php" class="border_btn08"><span>お子様新規登録画面</span></a></li>
    <li><a href="count.php" class="border_btn08"><span>登録分布</span></a></li>
    <li><a href="#" class="border_btn08" onclick="toggleSBMSection()"><span>SBM</span></a></li>
    <li><a href="logout.php" class="border_btn08"><span>ログアウト</span></a></li>
    <!-- 他のリンクもここに追加可能 -->
</ul>
   </nav>
</footer>
</main>
<script>function toggleMenu() {
    var navbar = document.getElementById('navbar');
    if (navbar.classList.contains('show')) {
        navbar.classList.remove('show');
    } else {
        navbar.classList.add('show');
    }
}
function toggleMenu() {
    var navbar = document.getElementById('navbar');
    navbar.classList.toggle('show');
}

</script>
<script>
    function toggleDetails(moduleId) {
        var details = document.getElementById(moduleId + '-details');
        details.classList.toggle('hidden');
    }
</script>     
<script>
    // 登録キッズ一覧と操作リンクを表示/非表示に切り替える関数
    function toggleKidsListAndOperations() {
        var kidsList = document.getElementById('kidsList');
        var displayStyle = kidsList.style.display === 'none' ? '' : 'none';
        kidsList.style.display = displayStyle;

        // 操作リンクを表示/非表示に切り替える
        <?php foreach ($children as $child): ?>
            var operations = document.getElementById('operations-<?= $child['id'] ?>');
            operations.style.display = displayStyle;
        <?php endforeach; ?>
    }
    // 「登録キッズ一覧」ボタンのイベントリスナーを設定
    document.getElementById('toggleKidsList').addEventListener('click', toggleKidsListAndOperations);

    function toggleMenu() {
    var navbar = document.getElementById('navbar');
    navbar.classList.toggle('show');

    function toggleMenu() {
    var navbar = document.getElementById('navbar');
    var icon = document.getElementById('menu-icon');
    navbar.classList.toggle('show');
    icon.style.display = icon.style.display === 'none' ? 'block' : 'none'; // メニューアイコンの表示を切り替え
}

}
</script>
</body>
</html>

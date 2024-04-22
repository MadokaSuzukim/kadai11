<?php
session_start();
error_reporting(E_ALL); 
ini_set('display_errors', '1');

// セッションに親のIDが保存されているかチェック
if (!isset($_SESSION['parent_id'])) {
    // セッションに親のIDがない場合はログインページにリダイレクト
    header('Location: login.php');
    exit;
}

// データベースに接続
include("funcs.php");
$pdo = db_conn();

// フォームから送信されたデータを受け取る
$name = $_POST["name"];
$nickname = $_POST["nickname"];
$birthdate = $_POST["birthdate"];
$gender = $_POST["gender"];
$likes = $_POST["likes"];
$parent_id = $_SESSION['parent_id']; // セッションから親のIDを取得


// ニックネームをセッションに保存
$_SESSION['nickname'] = $nickname;

// 親のIDがデータベースに存在するか確認
$checkSql = "SELECT id FROM parents WHERE id = :parent_id";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
$checkStmt->execute();
$parentExists = $checkStmt->fetch();

if (!$parentExists) {
    exit('指定された親のIDは存在しません。');
}

// データ登録SQL作成
$sql = "INSERT INTO children (name, nickname, birthdate, gender, likes, parent_id, indate) 
        VALUES (:name, :nickname, :birthdate, :gender, :likes, :parent_id, sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':nickname', $nickname, PDO::PARAM_STR);
$stmt->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
$stmt->bindValue(':likes', $likes, PDO::PARAM_STR);
$stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);

// SQLを実行し、結果をチェック
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:" . $error[2]);
} else {
    // 登録完了ページへリダイレクト
    header("Location: registered.php");
    exit;
}
?>

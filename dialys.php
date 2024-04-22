<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("funcs.php");
$pdo = db_conn();

// POSTデータ取得
$child_id = $_POST['child_id']; // child_id を POST データから取得
$date = $_POST['date'];
$content = $_POST['content'];

// データベース接続
$pdo = db_conn();

// データ登録SQL作成
$sql = "INSERT INTO diary (child_id, date, content) VALUES (:child_id, :date, :content)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $child_id, PDO::PARAM_INT);
$stmt->bindValue(':date', $date);
$stmt->bindValue(':content', $content);

$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:" . $error[2]);
} else {
    header("Location: feedback.php"); // 日記一覧ページへリダイレクト
}
?>

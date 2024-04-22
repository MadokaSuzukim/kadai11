<?php
// mission_start.php
session_start();
include("funcs.php");
$pdo = db_conn();

if (!isset($_SESSION['parent_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $missionId = $_POST['missions']; // ミッションIDを取得
    // ミッションの詳細をデータベースから取得する処理をここに追加
    // ミッション詳細ページへのリダイレクトなど
}

?>

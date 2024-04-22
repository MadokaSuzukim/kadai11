<?php
session_start();

// フォームから送信されたユーザー名とパスワード
$username = $_POST["username"];
$password = $_POST["password"];

// データベース接続
include("funcs.php");
$pdo = db_conn();

// ユーザー名を元にデータベースからユーザー情報を取得
$sql = "SELECT * FROM parents WHERE username = :username AND life_flg = 0";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    // SQL実行時にエラーがある場合の処理
    sql_error($stmt);
} else {
    // ユーザーデータの取得
    $val = $stmt->fetch();
    if ($val && password_verify($password, $val["password"])) {
        // パスワードが一致した場合はセッションにユーザー情報を保存し、リダイレクトする
        $_SESSION['parent_id'] = $val['id'];  // 正しい位置で親のIDをセッションに保存
        $_SESSION["chk_ssid"]  = session_id();
        $_SESSION["kanri_flg"] = $val['kanri_flg'];
        $_SESSION["name"]      = $val['name'];
        header("Location: home.php");
        exit();
    } else {
        // パスワードが一致しない場合はログインページにリダイレクトする
        header("Location: login.php");
        exit();
    }
}
?>


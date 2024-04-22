<?php
//1. POSTデータ取得
$id = $_GET["id"];  // IDをGETメソッドで取得

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//3. データ削除SQL作成
$stmt = $pdo->prepare("DELETE FROM children WHERE id=:id");  // 正しいSQL文
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  // IDをバインド（数値の場合 PDO::PARAM_INT）
$status = $stmt->execute(); // SQL文の実行

//4. データ削除処理後
if($status==false){
  sql_error($stmt);  // SQLエラー処理関数の呼び出し
}else{
  redirect("select.php");  // 削除後にデータ一覧ページにリダイレクト（余計な空白を削除）
}
?>

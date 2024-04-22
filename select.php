<?php
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM children"; // 対象のテーブルを変更
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
  sql_error($stmt); // SQLエラー時の関数呼び出し
}

//全データ取得
$values = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($values, JSON_UNESCAPED_UNICODE);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>こども情報表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;} td{border: 1px solid red;}</style>
</head>
<body id="main">
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>

<div>
    <div class="container jumbotron">
    <table>
      <tr>
        <th>ID</th>
        <th>名前</th>
        <th>ニックネーム</th>
        <th>生年月日</th>
        <th>性別</th>
        <th>好きなこと</th>
        <th>更新</th>
        <th>削除</th>
      </tr>
      <?php foreach($values as $v){ ?>
        <tr>
          <td><?=h($v["id"])?></td>
          <td><?=h($v["name"])?></td>
          <td><?=h($v["nickname"])?></td>
          <td><?=h($v["birthdate"])?></td>
          <td><?=h($v["gender"])?></td>
          <td><?=h($v["likes"])?></td>
          <td><a href="detail.php?id=<?=h($v["id"])?>">更新</a></td>
          <td><a href="delete.php?id=<?=h($v["id"])?>">削除</a></td>
        </tr>
      <?php } ?>
    </table>
    </div>
</div>

<script>
  const jsonStr = '<?=$json?>';
  const data = JSON.parse(jsonStr);
  console.log(data);
</script>
</body>
</html>

<?php
$id =$_GET["id"];
//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM children WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$v =  $stmt->fetch(); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<main>
  <div class="container">
    <h2>お子様の情報を更新してください</h2>
    <form method="POST" action="update.php">
      <div class="mb-3">
        <label for="name" class="form-label">名前：</label>
        <input type="text" class="form-control" id="name" name="name" value="<?=h($v['name'])?>" required>
      </div>
      <div class="mb-3">
        <label for="nickname" class="form-label">ニックネーム：</label>
        <input type="text" class="form-control" id="nickname" name="nickname" value="<?=h($v['nickname'])?>" required>
      </div>
      <div class="mb-3">
        <label for="birthdate" class="form-label">生年月日：</label>
        <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?=h($v['birthdate'])?>" required>
      </div>
      <div class="mb-3">
        <label for="gender" class="form-label">性別：</label>
        <select class="form-select" id="gender" name="gender">
          <option value="male" <?= $v['gender']=='male'?'selected':'' ?>>男性</option>
          <option value="female" <?= $v['gender']=='female'?'selected':'' ?>>女性</option>
          <option value="other" <?= $v['gender']=='other'?'selected':'' ?>>その他</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="likes" class="form-label">好きなこと：</label>
        <textarea class="form-control" id="likes" name="likes" rows="4"><?=h($v['likes'])?></textarea>
      </div>
      <input type="hidden" name="id" value="<?=h($v['id'])?>">
      <button type="submit" class="btn btn-primary">更新</button>
    </form>
  </div>
</main>
   
  </div>
</form>
<!-- Main[End] -->


</body>
</html>




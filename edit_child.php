<?php
session_start();
include("funcs.php");
$pdo = db_conn();

if (!isset($_GET['id'])) {
    header('Location: home.php'); // IDがない場合は一覧に戻る
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM children WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$child = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $stmt = $pdo->prepare("UPDATE children SET name = :name, birthdate = :birthdate WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
    $stmt->execute();

    header('Location: home.php');
    exit;
}
?>

<form method="post">
    名前: <input type="text" name="name" value="<?= htmlspecialchars($child['name']) ?>">
    生年月日: <input type="date" name="birthdate" value="<?= $child['birthdate'] ?>">
    <input type="submit" value="更新">
</form>

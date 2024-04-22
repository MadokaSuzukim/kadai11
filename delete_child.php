<?php
session_start();
include("funcs.php");
$pdo = db_conn();

if (!isset($_GET['id'])) {
    header('Location: home.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM children WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location: home.php');
exit;
?>

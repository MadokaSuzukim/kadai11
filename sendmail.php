<?php
session_start();
include("funcs.php");
$pdo = db_conn();
// PHPMailerを含むファイルをインクルード
require 'path/to/PHPMailerAutoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailerのAutoload

// メールアドレスからユーザーを検索して、リセットトークンを生成して保存する

// ここでデータベースへの接続と操作を行うと仮定します

// 以下の例では、$tokenにはランダムなトークンが含まれているとします
$token = bin2hex(random_bytes(16));

// トークンをデータベースに保存し、有効期限を設定するコードがここに入ります

// 送信メールの準備
$mail = new PHPMailer(true);
// try {
//     // サーバー設定
//     $mail->isSMTP();
//     $mail->Host = 'smtp.example.com';
//     $mail->SMTPAuth = true;
//     $mail->Username = 'your_email@example.com';
//     $mail->Password = 'your_password';
//     $mail->SMTPSecure = 'tls';
//     $mail->Port = 587;

    // 送信者情報
    $mail->setFrom('your_email@example.com', 'Your Name');
    
    // 受信者情報
    $mail->addAddress($_POST['email']);

    // メール内容
    $mail->isHTML(true);
    $mail->Subject = 'パスワードの再設定';
    $mail->Body = '以下のリンクをクリックしてパスワードを再設定してください：<br>'
                    . '<a href="http://example.com/reset_password.php?token=' . $token . '">パスワードを再設定する</a>';

    // メール送信
    $mail->send();
    echo 'メールを送信しました。';
} catch (Exception $e) {
    echo 'メールの送信に失敗しました。エラー: ', $mail->ErrorInfo;
}
?>

const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');

let x = 0;
const y = canvas.height / 2;
const radius = 20;
const speed = 5;

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height); // キャンバスをクリア
    ctx.beginPath();
    ctx.arc(x, y, radius, 0, Math.PI * 2, true); // 円を描画
    ctx.fill();
    x += speed;

    if (x - radius > canvas.width) {
        x = 0; // 円が画面外に出たら位置をリセット
    }
    requestAnimationFrame(animate); // 次のフレームをリクエスト
}

animate();


function checkMissionStatus() {
    // ここでミッションの状態をチェック（例: APIからのデータ取得や、ゲームの内部状態の確認）
    return true; // この例では、状態を常にtrueとしています
}

function startAnimation() {
    if (checkMissionStatus()) {
        animate(); // ミッションがクリアされたらアニメーションを開始
    }
}

startAnimation();

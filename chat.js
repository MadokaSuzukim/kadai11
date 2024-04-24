// アファメーション一覧の初期化
let affirmations = [];

$(document).ready(function() {
    // ローカルストレージからアファメーションを取得して表示する
    displayAffirmations();


    // 「追加」ボタンがクリックされたときの処理
$("#addAffirmation").on("click", function() {
    var newAffirmation = $("#newAffirmation").val();
    addAffirmation(newAffirmation);

    // アファメーションを追加した後に画面を更新
    updateAffirmations();
});

    // アファメーション一覧の削除ボタンがクリックされたときの処理
    $(document).on("click", ".remove", function() {
        var index = $(this).data("index");
        removeAffirmation(index);
    });

    // チャットメッセージの送信イベント
$("#send").on("click", function () {
    const message = $("#text").val();
    
    // メッセージ内に特定のキーワードが含まれているかチェック
    if (message.includes("アファメーション")) {
        // ローカルストレージから現在のアファメーションの一覧を取得
        let affirmationsFromStorage = JSON.parse(localStorage.getItem("affirmations")) || [];
        
        // 新しいアファメーションを追加
        affirmationsFromStorage.push(message);
        
        // ローカルストレージにアファメーションを保存
        localStorage.setItem("affirmations", JSON.stringify(affirmationsFromStorage));
        
        // アファメーション一覧を更新
        updateAffirmations();
    }
    });
});

// ローカルストレージにアファメーションを追加する関数
function addAffirmationToLocalStorage(affirmations) {
    // 更新されたアファメーションをローカルストレージに保存
    localStorage.setItem("affirmations", JSON.stringify(affirmations));
}

// アファメーション一覧からアファメーションを削除する関数
function removeAffirmation(index) {
    // 保存されているアファメーションを取得
    var affirmations = JSON.parse(localStorage.getItem("affirmations")) || [];

    // 指定されたインデックスのアファメーションを削除
    affirmations.splice(index, 1);

    // 更新されたアファメーションをローカルストレージに保存
    localStorage.setItem("affirmations", JSON.stringify(affirmations));

    // アファメーション一覧を再描画
    displayAffirmations();
}

// ローカルストレージからアファメーションを取得して表示する関数
function displayAffirmations() {
    // 保存されているアファメーションを取得
    var affirmationsFromStorage = JSON.parse(localStorage.getItem("affirmations")) || [];

    // アファメーション一覧を表示する要素の取得
    const $affirmationList = $("#affirmationList");
    
    // 一覧をクリアしてから再描画
    $affirmationList.empty();
    
    // アファメーション一覧をループして表示
    affirmationsFromStorage.forEach((affirmation, index) => {
        // 削除ボタンを付けて表示
        $affirmationList.append(`<div>${index + 1}. ${affirmation} <span class="remove" data-index="${index}">削除</span></div>`);
    });
}

// アファメーションをローカルストレージに追加する関数
function addAffirmation(affirmation) {
    // 保存されているアファメーションを取得
    var affirmationsFromStorage = JSON.parse(localStorage.getItem("affirmations")) || [];
    
    // 新しいアファメーションを追加
    affirmationsFromStorage.push(affirmation);

    // ローカルストレージに更新されたアファメーションを保存
    addAffirmationToLocalStorage(affirmationsFromStorage);
}

// アファメーション一覧を更新する関数
function updateAffirmations() {
    // アファメーション一覧を表示する要素の取得
    const $affirmationList = $("#affirmationList");
    
    // 一覧をクリアしてから再描画
    $affirmationList.empty();
    
    // アファメーション一覧を再度表示
    displayAffirmations();
}

// セクションヘッダーがクリックされたときの処理
document.querySelectorAll('.section-header').forEach(header => {
    header.addEventListener('click', () => {
      const content = header.nextElementSibling;
      content.style.display = content.style.display === 'none' ? 'block' : 'none';
    });
  });
  
  // セクションヘッダーがクリックされたときの処理
document.querySelectorAll('.section-sengen').forEach(header => {
    header.addEventListener('click', () => {
      const content = header.nextElementSibling;
      content.style.display = content.style.display === 'none' ? 'block' : 'none';
    });
  });
  
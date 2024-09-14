let form = document.querySelector('.thread_form');
let isFormValid = true;

form.addEventListener('submit', function(event) {
  let title = form.querySelector('#title').value.trim();
  let comment = form.querySelector('#comment').value.trim();
  let image = form.querySelector('#image').files[0]; // 画像ファイルを取得
  isFormValid = true;

  
  //全ての入力が空かどうか
  if(!title && !comment && !image) {
    form.querySelector('#errors').innerHTML = 'タイトル、コメント、画像のいずれかを入力してください。';
    isFormValid = false;
  } else {
    form.querySelector('#errors').innerHTML = '';
  }

  // タイトルのバリデーション
  if (title.length > 100) {
    form.querySelector('#err1').innerHTML = 'タイトルを100文字以下で入力してください';
    isFormValid = false;
  } else {
    form.querySelector('#err1').innerHTML = '';
  }

  // コメントのバリデーション
  if (comment.length > 200) {
    form.querySelector('#err2').innerHTML = 'コメントを200文字以下で入力してください';
    isFormValid = false;
  } else {
    form.querySelector('#err2').innerHTML = '';
  }

  // 画像のバリデーション（画像が選択されている場合のみチェック）
  if (image) {
    if (image.size > 2 * 1024 * 1024) { // 2MBを超えるかどうかをチェック
      form.querySelector('#err3').innerHTML = '画像は2MB以下でアップロードしてください';
      isFormValid = false;
    } else {
      form.querySelector('#err3').innerHTML = ''; // エラーなし
    }
  } else {
    form.querySelector('#err3').innerHTML = ''; // 画像が選択されていない場合、エラーなし
  }

  // バリデーションエラーがあれば送信を防ぐ
  if (!isFormValid) {
    event.preventDefault();
  }
});

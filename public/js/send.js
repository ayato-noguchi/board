document.querySelector('.thread_form').addEventListener('submit', function() {
  //下記の記述をコメントアウトしたらエラー解消
  //  event.preventDefault(); 
  let formData = new FormData();
  formData.append('title', $('#title').val());
  formData.append('comment', $('#comment').val());
  formData.append('token', $('input[name="token"]').val());
  formData.append('type', 'createthread');

  let imageFile = $('#image')[0].files[0];  // ファイル入力から画像を取得
  formData.append('image', imageFile);  // FormDataに画像ファイルを追加

  if (isFormValid) { 
    $.ajax({
      url: '../Controller/Thread.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
    }).done(function(data) {
      console.log('成功', data);
      alert('成功');
    }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
      alert(XMLHttpRequest);
      alert(textStatus);
      alert(errorThrown);
    });
  }
});

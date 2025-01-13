document.querySelector('.thread_form').addEventListener('submit',  function() {
  let formData = new FormData(this);
  let imageFile = $('#image')[0].files[0];  // ファイル入力から画像を取得
  formData.append('image', imageFile);  // FormDataに画像ファイルを追加
  console.log(isFormValid);
  if (isFormValid) { 
    $.ajax({
      url: '../Controller/Thread.php',
      type: 'POST',
      data: formData,
      dataType: 'json'
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


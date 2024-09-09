let isFormValid = false;

  document.querySelectorAll('.thread_form').forEach(function(form){
    form.addEventListener('submit', function(event){

      let title = form.querySelector('#title').value;
      let comment = form.querySelector('#comment').value;
      let image = form.querySelector('#image').files[0];
      isFormValid = true;

      console.log('title', title);
      console.log('comment', comment);
  
  
      //タイトルのバリデーション
      if(title.length > 100 ){
        form.querySelector('#err1').innerHTML = 'タイトルを100文字以下で入力してください';
        isFormValid = false;
      } else {
        form.querySelector('#err1').innerHTML = '';
      }
  
      //コメントのバリデーション
      if(comment.length > 200 ){
        form.querySelector('#err2').innerHTML = 'コメントを200文字以下で入力してください';
        isFormValid = false;
      } else {
        form.querySelector('#err2').innerHTML = '';
      }

      //画像のバリデーション
      if(image) {
        form.querySelector('#err2').innerHTML = 'コメントを200文字以下で入力してください';
        isFormValid = false;
      } else {
      form.querySelector('#err2').innerHTML = '';
      }
  
      //バリデーションでエラーがある場合、フォームの送信を防ぐ
      if(!isFormValid){
        event.preventDefault();
      }
  });
});

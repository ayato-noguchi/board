document.querySelector('.thread_form').addEventListener('submit', function(event) {
  // event.preventDefault(); 


  if (isFormValid) { 
    $.ajax({
      url: '../Controller/Thread.php',
      type: 'POST',
      
      data: {
        title: $('#title').val(),
        comment: $('#comment').val(),
        token: $('input[name="token"]').val(), 
        type: 'createthread'
      }
      
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

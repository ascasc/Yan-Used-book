$(document).ready(function(){
  var panel={
    el: '#panel',
  };
  var signu_success={
    el: '#signu-success',
  };
  var signup={
      el: '#signup',
      alert_msg: function(alert_msg) {
        $('.error-msg').addClass('open');
        $(signup.el).find('.error-msg .alert-danger').text(alert_msg);
      },
      alert_msg_off: function() {
        $('.error-msg').removeClass('open');
      },
  };
    $(panel.el)
      .on('click', '.login-nav', function(e){//開啟登入視窗
        $('#login').addClass('open');
    })
      .on('click', '.signup-nav', function(e){//開啟註冊視窗
        $(signup.el).addClass('open');
    })
      .on('click', '.close', function(e){   //關閉視窗處理
        $(signup.el).removeClass('open');  
        $('#login').removeClass('open');
        $(signu_success.el).removeClass('open');
        $(this).siblings('input').val('');
        signup.alert_msg_off();
    })
      .on('click', '#signup .button button', function(e) {//註冊送出並且驗證
        e.preventDefault();
        var data=$('#signup.login-signup').find('form').serialize();
        $.post("signup/signup-create.php", data, function(){})
          .done(function(data, textStatus, jqXHR) {
            $(signup.el).find('.close').click();
            $(signu_success.el).addClass('open');
        })
          .fail(function(xhr, textStatus, errorThrown){
            if(errorThrown !='Bad Request'){
              signup.alert_msg_off();
            }else{
              signup.alert_msg(xhr.responseText);
            }
      })
    });
  });
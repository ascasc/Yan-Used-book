$(document).ready(function(){
  var panel={
    el: '#panel',
  };
  var login={
    el: '#login',
  };
  var signup={
    el: '#signup',
  };
  var signu_success={
    el: '#signu-success',
    
  };
  var public_signup_login={
    alert_msg: function(el,alert_msg) {
      $('.error-msg').addClass('open');
      $(el).find('.error-msg .alert-danger').text(alert_msg);
    },
    alert_msg_off: function() {
      $('.error-msg').removeClass('open');
    },
    alert_msg__success: function(text) {
      $(signu_success.el).find('p').text('');
      $(signu_success.el).find('p').text(text);
      $(signu_success.el).addClass('open');
    } 
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
        public_signup_login.alert_msg_off();
    })
      .on('click', '#signup .button button', function(e) {//註冊送出並且驗證
        e.preventDefault();
        var data=$('#signup.login-signup').find('form').serialize();
        $.post("signup_login/signup-create.php", data, function(){})
          .done(function(data, textStatus, jqXHR) {
            $(signup.el).find('.close').click();
            public_signup_login.alert_msg__success(data.name);
        })
          .fail(function(xhr, textStatus, errorThrown){
            if(errorThrown !='Bad Request'){
              public_signup_login.alert_msg_off();
            }else{
              public_signup_login.alert_msg(signup.el,xhr.responseText);
            }
      })
    })
      .on('click', '#login .button button', function(e) {//註冊送出並且驗證
      e.preventDefault();
      var data=$('#login.login-signup').find('form').serialize();
      $.post("signup_login/login.php", data, function(){})
        .done(function(data, textStatus, jqXHR) {
          $(signup.el).find('.close').click();
          public_signup_login.alert_msg__success(data.name);
      })
        .fail(function(xhr, textStatus, errorThrown){
          if(errorThrown !='Bad Request'){
            public_signup_login.alert_msg_off();
          }else{
            public_signup_login.alert_msg(login.el,xhr.responseText);
          }
    })
  });
});
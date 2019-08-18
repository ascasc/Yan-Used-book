$(document).ready(function(){
  
  var nav_template = $('#nav-item-template').html();
  var nav_handlebars =Handlebars.compile(nav_template);

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
  var update_member={
    el:'#update-member',
  };
  var template ={
    nav:function(li_1, li_val_1, li_2_1, li_val_2, li_2_2){
        var login_nav_item={
        nav_li_1: li_1,
        nav_li_val_1: li_val_1,
        nav_li_2_1: li_2_1,
        nav_li_val_2: li_val_2,
        nav_li_2_2: li_2_2
      };
      var login_nav_complile = nav_handlebars(login_nav_item);
      $(panel.el).find('#header nav .nav').prepend(login_nav_complile);
    },
  };
  var public_signup_login={//登入與註冊訊息
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

  template.nav('login-nav','登入','signup-nav', '註冊');
    $(panel.el)
      .on('click', '.login-nav', function(e){//開啟登入視窗
        $('#login').addClass('open');
    })
      .on('click', '.signup-nav', function(e){//開啟註冊視窗
        $(signup.el).addClass('open');
    })
      .on('click', '.update-member-nav', function(e){//登入後的修改資料
        $(update_member.el).addClass('open');
    })
      .on('click', '.dropdown', function(e) {//呼叫選單
      e.preventDefault();
      $(".Menu-Panel").slideToggle(200);
    }) 
      .on('click', '.shop-cart-nav', function(e) {//呼叫購物車
      e.preventDefault();
      $(".shopcart-Panel").slideToggle(200);
    })
      .on('click', '.close', function(e){   //關閉視窗處理
        $(signup.el).removeClass('open');  
        $('#login').removeClass('open');
        $(signu_success.el).removeClass('open');
        $(update_member.el).removeClass('open');
        $(this).siblings('input').val('');
        public_signup_login.alert_msg_off();
    })
      .on('click', '#signup .button', function(e) {//註冊送出並且驗證
        e.preventDefault();
        var data=$('#signup.login-signup').find('form').serialize();
        $.post("signup_login/signup-create.php", data, function(){})
          .done(function(data, textStatus, jqXHR) {//註冊成功回傳到HTML成功的訊息
            $(signup.el).find('.close').click();
            public_signup_login.alert_msg__success(data.name);
        })
          .fail(function(xhr, textStatus, errorThrown){//註冊錯誤回傳到HTML錯誤訊息
            if(errorThrown !='Bad Request'){
              public_signup_login.alert_msg_off();
            }else{
              public_signup_login.alert_msg(signup.el,xhr.responseText);
            }
      })
    })
      .on('click', '#login .button', function(e) {//登入送出並且驗證
      e.preventDefault();
      var data=$('#login.login-signup').find('form').serialize();
      $.post("signup_login/login.php", data, function(){})
        .done(function(data, textStatus, jqXHR) {//登入成功回傳到HTML成功的訊息
          $(signup.el).find('.close').click();
          public_signup_login.alert_msg__success(data.name);
          $(panel.el).find('#header nav li').remove();
          template.nav('shop-cart-nav','購物車','dropdown', '選單', 'dropdown-toggle');
      })
        .fail(function(xhr, textStatus, errorThrown){//登入錯誤回傳到HTML錯誤訊息
          if(errorThrown !='Bad Request'){
            public_signup_login.alert_msg_off();
          }else{
            public_signup_login.alert_msg(login.el,xhr.responseText);
          }
    })
  });
});
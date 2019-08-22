$(document).ready(function(){
  //handlebard最初的準備時候
  var nav_template = $('#nav-item-template').html();
  var nav_handlebars =Handlebars.compile(nav_template);

  var panel={
    el: '#panel',
  };
  // 登入視窗
  var login={ 
    el: '#login',
  };
  // 註冊
  var signup={
    el: '#signup',
  };
  // 狀態訊息視窗
  var signu_success={
    el: '#signu-success',
  };
  // 修改個人資料視窗
  var update_member={
    el:'#update-member',
  };
  // 購物清單視窗
  var shopping_list ={
    el: '#shopping-list',
  }
  // 選單視窗
  var Menu_Panel ={
    el: '#Menu-Panel',
  }
  // 購物車視窗
  var shopcart_Panel={
    el: '#shopcart-Panel',
  }
  // 商品書單清單
  var commodity_list={
    el: '#commodity-list',
  };
  //新增商品視窗
  var insert_commodity={
    el: '#insert-commodity',
  };
  //主要為Template物件使用
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
  // 主要為登入與註冊訊息物件使用
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
  // 為登入的nav
  template.nav('login-nav','登入','signup-nav', '註冊');
    $(panel.el)
      .on('click', '#header li', function(e){
        e.preventDefault();
        if($(this).is('.login-nav')){//開啟登入視窗
          $(login.el).addClass('open');
        }
        if($(this).is('.signup-nav')){//開啟註冊視窗
          $(signup.el).addClass('open');
        }
        if($(this).is('.dropdown')){//呼叫選單
          $(Menu_Panel.el).slideToggle(200);
        }
        if($(this).is('.shop-cart-nav')){//呼叫購物車
          $(shopcart_Panel.el).slideToggle(200);
        }
      })
      .on('click', '#commodity li', function(e) {//開啟購物清單
        e.preventDefault();
        $(commodity_list.el).addClass('open');
      })
      .on('click', '#Menu-Panel li', function(e){//登入後的修改資料
        e.preventDefault();
        if($(this).is('.update-member-nav')){
          $(update_member.el).addClass('open');
        }
        if($(this).is('.shopping-list-nav')){//開啟購物清單
          $(shopping_list.el).addClass('open');
        }
        if($(this).is('.insert-commodity-nav')){//開啟新增商品
          $(insert_commodity.el).addClass('open');
        }
    })
      .on('click', '.close', function(e){   //關閉視窗處理
        e.preventDefault();
        $(this).closest(signup.el).removeClass('open');
        $(this).closest(login.el).removeClass('open');
        $(this).closest(signu_success.el).removeClass('open');
        $(this).closest(update_member.el).removeClass('open');
        $(this).closest(shopping_list.el).removeClass('open');
        $(this).closest(commodity_list.el).removeClass('open');
        $(this).closest(insert_commodity.el).removeClass('open');
        $(this).siblings('input').val('');
        public_signup_login.alert_msg_off();
    })
      .on('click', '.button', function(e) {
        e.preventDefault();
        if($(this).is('.signup')){//註冊送出並且驗證
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
          });
        }
        if($(this).is('.login')){//登入送出並且驗證
          var data=$('#login.login-signup').find('form').serialize();
          $.post("signup_login/login.php", data, function(){})
            .done(function(data, textStatus, jqXHR) {//登入成功回傳到HTML成功的訊息
              $(panel.el).find('.close').click();
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
          });
        }
    });
});
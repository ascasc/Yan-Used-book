$(document).ready(function(){
  // 商品書單
  var commodity_template = $('#commodity-item-template').html();
  var commodity_template_compile = Handlebars.compile(commodity_template);
  var commodity_UI = '';
  // 商品書單清單
  var commodity_list_template = $('#commodity-list-item-template').html();
  var commodity_list_template_compile = Handlebars.compile(commodity_list_template);

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
  // 商品書單
  var commodity={
    el: '#commodity',
  };
  // 商品書單清單
  var commodity_list={
    el: '#commodity-list',
  };
  //新增商品視窗
  var insert_commodity={
    el: '#insert-commodity',
  };
  var update_member_admin={
    el:'#update-member-admin',
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
    alert_msg_success: function(text) {
      $(signu_success.el).find('p').text('');
      $(signu_success.el).find('p').text(text);
      $(signu_success.el).addClass('open');
    } 
  };

  $.each(commodities, function (index, commodity) { 
    commodity_UI = commodity_UI + commodity_template_compile(commodity);
  });
  $(commodity.el).find('.container ul.row').append(commodity_UI);

  if(login_status=='On'){
    public_signup_login.alert_msg_success('已登入狀態');
  }
  
  $(panel.el)
  .on('submit', 'form', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if($(this).is('#signup_form')){//註冊送出並且驗證
          var data=$('#signup.login-signup').find('form').serialize();
          $.post("signup_login/signup-create.php", data, function(){})
            .done(function(data, textStatus, jqXHR) {//註冊成功回傳到HTML成功的訊息
              $(signup.el).find('.close').click();
              public_signup_login.alert_msg_success(data.name);
          })
            .fail(function(xhr, textStatus, errorThrown){//註冊錯誤回傳到HTML錯誤訊息
              if(errorThrown !='Bad Request'){
                public_signup_login.alert_msg_off();
              }else{
                public_signup_login.alert_msg(signup.el,xhr.responseText);
              }
          });
        }
        if($(this).is('#login_form')){//登入送出並且驗證
          var data=$('#login.login-signup').find('form').serialize();
          $.post("signup_login/login.php", data, function(){})
            .done(function(data, textStatus, jqXHR) {//登入成功回傳到HTML成功的訊息
              $(panel.el).find('.close').click();
              window.location.reload();
          })
            .fail(function(xhr, textStatus, errorThrown){//登入錯誤回傳到HTML錯誤訊息
              if(errorThrown !='Bad Request'){
                public_signup_login.alert_msg_off();
              }else{
                public_signup_login.alert_msg(login.el,xhr.responseText);
              }
          });
        }
        if($(this).is('#create_book_form')){
          $.ajax({
            url: "admin/create_book.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
          }) 
          .done(function(data, textStatus, jqXHR) {//註冊成功回傳到HTML成功的訊息
            $(insert_commodity.el).find('.close').click();
            window.location.reload();
        })
          .fail(function(xhr, textStatus, errorThrown){//註冊錯誤回傳到HTML錯誤訊息
            if(errorThrown !='Bad Request'){
              public_signup_login.alert_msg_off();
            }else{
              public_signup_login.alert_msg(insert_commodity.el,xhr.responseText);
            }
          });
        }
    })
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
    .on('click', '#commodity li', function(e) {//開啟商品書單清單
        e.preventDefault();
        var id = $(this).data('id');
        $(commodity_list.el).addClass('open');
        $.post("member/commodity_list.php", {id:id},
          function (data, textStatus, jqXHR) {
            $(commodity_list.el).find('.container').html('');
            $(commodity_list.el).find('.container').append(commodity_list_template_compile(data)); 
        });
        
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
        if($(this).is('.update-member-admin-nav')){//開啟管理員修改會員資料
          $(update_member_admin.el).addClass('open');
        }
        if($(this).is('.sign-out')){//登出
          $.post("signup_login/sign-out.php");
          window.location.reload();
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
        $(this).closest(insert_commodity.el).removeClass('open');//關閉新增商品
        $(this).closest(insert_commodity.el).find('img').removeClass('open');
        $(this).closest(update_member_admin.el).removeClass('open');
        $(this).siblings('#create_book_form ').find('input:not(.button)').val('');
        public_signup_login.alert_msg_off();
    })
    
    .on('change','#insert-commodity form .file_img', function(e){
      const file = this.files[0];//將上傳檔案轉換為base64字串
          
      const fr = new FileReader();//建立FileReader物件
      fr.onload = function (e) {
        $('#insert-commodity').find('img')
        .addClass('open')
        .attr('src', e.target.result);//读取的结果放入圖片
      };
      // 使用 readAsDataURL 將圖片轉成 Base64
      fr.readAsDataURL(file);
    });
    
});
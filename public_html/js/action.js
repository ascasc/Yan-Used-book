$(document).ready(function(){
  // 商品書單
  var commodity_template = $('#commodity-item-template').html();
  var commodity_template_compile = Handlebars.compile(commodity_template);
  var commodity_UI = '';
  // 商品書單清單
  var commodity_list_template = $('#commodity-list-item-template').html();
  var commodity_list_template_compile = Handlebars.compile(commodity_list_template);
  
  //購物車
  var shopcart_template = $('#shopcart-Panel-item-template').html();
  var shopcart_template_compile = Handlebars.compile(shopcart_template);
  var shopcart_UI ='';

  //管理員修改資料
  var admin_update_commodity_data_template = $('#admin-update-commodity-data-item-template').html();
  var admin_update_commodity_data_template_compile = Handlebars.compile(admin_update_commodity_data_template);
  var admin_update_commodity_data_UI ='';
  //管理員選擇修改資料
  var admin_update_commodity_template = $('#admin-update-commodity-item-template').html();
  var admin_update_commodity_template_compile = Handlebars.compile(admin_update_commodity_template);
  //管理員購物清單
  var shopping_list_item_template = $('#shopping-list-item-template').html();
  var shopping_list_item_template_compile = Handlebars.compile(shopping_list_item_template);
  //修改會員資料
  var update_member_SQL_item_template= $('#update-member-SQL-item-template').html();
  var update_member_SQL_item_template_compile = Handlebars.compile(update_member_SQL_item_template);
  //新增商品與修改商品
  var insert_commodity_item_template= $('#insert-commodity-item-template').html();
  var insert_commodity_item_template_compile = Handlebars.compile(insert_commodity_item_template);
//新增商品與修改商品
var update_commodity_item_template= $('#update-commodity-item-template').html();
var update_commodity_item_template_compile = Handlebars.compile(update_commodity_item_template);
  //管理員購物清單狀態箱子數字
  var shopping_list_admin_status_num=0;
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
  //進入首頁顯示管理員修改資料
  var update_member_admin={
    el:'#update-member-admin',
  };
  //購物車系統
  var shopcart_Panel={
    el:'#shopcart-Panel',
  };
  //管理員購物清單
  var shopping_list_admin={
    el:'#shopping-list-admin',
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
  //進入首頁顯示商品書單
  $.each(commodities, function (index, commodity) {
    commodity_UI = commodity_UI + commodity_template_compile(commodity);
  });

  $(commodity.el).find('.container ul.row').append(commodity_UI);

  //進入首頁顯示購物車
  $.each(shopcart, function (index, shopcarts) { 
    if(index>=0){
      $(shopcart_Panel.el).find('.container').html('');
    }
    shopcart_UI = shopcart_UI + shopcart_template_compile(shopcarts);
    
  });
  $(shopcart_Panel.el).find('.container').append(shopcart_UI);
  
  //顯示是否為登入
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
        if($(this).is('#create_book_form')){//新增商品
          $.ajax({
            url: "admin/create_book.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
          }) 
          .done(function(data, textStatus, jqXHR) {//新增商品回傳到HTML成功的訊息
            $(insert_commodity.el).find('.close').click();
            //進入首頁顯示商品書單
            commodity_UI='';
            $(commodity.el).find('.container ul.row').html('');
            $.each(data.data, function (index, commodity) {
              commodity_UI = commodity_UI + commodity_template_compile(commodity);
            });
            $(commodity.el).find('.container ul.row').append(commodity_UI);
        })
          .fail(function(xhr, textStatus, errorThrown){//新增商品錯誤回傳到HTML錯誤訊息
            if(errorThrown !='Bad Request'){
              public_signup_login.alert_msg_off();
            }else{
              public_signup_login.alert_msg(insert_commodity.el,xhr.responseText);
            }
          });
        }
        if($(this).is('#admin-update-commodity-form')){//更改使用者信箱
          var data=$(this).serialize();
          $(this).closest('ul').html('');
          $.post("admin/update_admin_commodity_data.php", data, function(){})
            .done(function(data, textStatus, jqXHR) {
              //進入首頁顯示管理員修改資料
              admin_update_commodity_data_UI= '';
              $.each(data.data, function (index, admin_update_customer_data) {
                admin_update_commodity_data_UI = admin_update_commodity_data_UI + admin_update_commodity_data_template_compile(admin_update_customer_data);
              });
              $(update_member_admin.el).find('ul').append(admin_update_commodity_data_UI);
            })
            .fail(function(xhr, textStatus, errorThrown){//登入錯誤回傳到HTML錯誤訊息
              if(errorThrown =='Bad Request'){
                public_signup_login.alert_msg_success(xhr.responseText);
              }
          });
        }
        if($(this).is('#update-data-form')){//修改會員資料
          var data = $(this).serialize();
          $.post("member/update_data.php", data, function(){})
            .done(function(data, textStatus, jqXHR) {
              public_signup_login.alert_msg_success(data.data);
            })
            .fail(function(xhr, textStatus, errorThrown){//錯誤回傳到HTML錯誤訊息
              if(errorThrown =='Bad Request'){
                public_signup_login.alert_msg_success(xhr.responseText);
              }
          });
        }
        if($(this).is('#update-password-form')){//修改密碼
          var data = $(this).serialize();
          $.post("member/update_password.php", data, function () {})
            .done(function(data, textStatus, jqXHR) {
              public_signup_login.alert_msg_success(data.data);
              $(update_member.el).find('.close').click();
            })
            .fail(function(xhr, textStatus, errorThrown) {
              if(errorThrown =='Bad Request'){
                public_signup_login.alert_msg_success(xhr.responseText);
              }
          });
        }
        if($(this).is('#update_book_form')){//修改商品
          $.ajax({
            url: "admin/update_book.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
          }) 
          .done(function(data, textStatus, jqXHR) {//更新商品成功回傳到HTML成功的訊息
            $(insert_commodity.el).find('.close').click();
            public_signup_login.alert_msg_success(data.name);
            //進入首頁顯示商品書單
            commodity_UI='';
            $(commodity.el).find('.container ul.row').html('');
            $.each(data.data, function (index, commodity) {
              commodity_UI = commodity_UI + commodity_template_compile(commodity);
            });
            $(commodity.el).find('.container ul.row').append(commodity_UI);
          })
          .fail(function(xhr, textStatus, errorThrown){//更新商品錯誤回傳到HTML錯誤訊息
            if(errorThrown =='Bad Request'){
              public_signup_login.alert_msg_success(xhr.responseText);
            }
          });
        }
    })
    .on('click', '#header li', function(e){//開啟nav
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
    .on('click', '#commodity-list .button', function(e) {//加入購物車
      e.preventDefault();
      var id = $(this).siblings('.container').find('.content').data('id');
      var shopcart_add_UI ='';
      $.post("member/shopcart.php", {id:id}, function(){})
        .done(function(data, textStatus, jqXHR) {
          $.each(data, function (index, shopcart) { 
            if(index>=0){
              $(shopcart_Panel.el).find('.container').html('');
              shopcart_add_UI = shopcart_add_UI + shopcart_template_compile(shopcart);
            }
          });
          $(shopcart_Panel.el).find('.container').append(shopcart_add_UI);
          $(commodity_list.el).find('.close').click();//關閉商品書單
          public_signup_login.alert_msg_success('加入購物車成功。');
        })
        .fail(function(xhr, textStatus, errorThrown){//之前已經加入購物車當中
          if(errorThrown =='Bad Request'){
            public_signup_login.alert_msg_success(xhr.responseText);
          }
        });
    
  })
    .on('click', '#shopcart-Panel .container li .delete',function(e){//刪除購物車
      var id = $(this).data('id');
      $(this).closest('li').remove();
      $.post("member/delete_shopcart.php", {id:id});
      if($(shopcart_Panel.el).find('.container').html()==0)
      {
        $(shopcart_Panel.el).find('.container').html('<p>你的購物車是空的</p>');
      } 
  })
    .on('click', '#shopcart-Panel .button',function(e){//結帳
      $.post("member/checkout.php", function(){})
        .done(function(data, textStatus, jqXHR) {
          $.each(data.data, function (indexInArray, datas) { 
            $('#commodity .container ul').find(datas).remove();
          });
          public_signup_login.alert_msg_success(data.name);
        })
        .fail(function(xhr, textStatus, errorThrown){
          if(errorThrown =='Bad Request'){
            public_signup_login.alert_msg_success(xhr.responseText);
          }
        });
      $(shopcart_Panel.el).slideToggle(200); 
      $(shopcart_Panel.el).find('.container').html('');
      if($(shopcart_Panel.el).find('.container').html()==0)//購物車空的時候
      {
        $(shopcart_Panel.el).find('.container').html('<p>你的購物車是空的</p>');
      }
      $.post("member/Select_Ｍap_data.php", function(){})
        .done(function(data, textStatus, jqXHR) {

        })
        .fail(function(xhr, textStatus, errorThrown){//電子地圖
          if(errorThrown =='Bad Request'){
            window.open('ecpay/sample_CvsMap.php', '電子地圖', config='height=800,width=1020');
          }
        });
      
    })
    .on('click', '#Menu-Panel li', function(e){//登入後的修改資料
        e.preventDefault();
        if($(this).is('.update-member-nav')){//修改資料
          $(update_member.el).addClass('open');
          $('#update-member').find('.content').html(' ');
          $('.curren').removeClass('curren');
          $(update_member.el).find('.Menu').children('li').first().find('a').addClass('curren');
          $.post("member/Select_customer_data.php",function (data, textStatus, jqXHR) {
            $(update_member.el).find('.content').append(update_member_SQL_item_template_compile(data));
            $(update_member.el).find('ul.content li[id!=update-data]').hide();
          });
        }
        if($(this).is('.shopping-list-nav')){//開啟購物清單
          $(shopping_list.el).addClass('open');
          $(shopping_list_admin.el).addClass('open');
          $(shopping_list_admin.el).find('ul').html('');
          $.post("member/shopping_list.php",function (data, textStatus, jqXHR) {
            var shopping_list_item_UI ='';
            $.each(data.data, function (index, datas) { 
              shopping_list_item_UI = shopping_list_item_UI + shopping_list_item_template_compile(datas);
            });
            $(shopping_list_admin.el).find('ul').append(shopping_list_item_UI);
            $(shopping_list_admin.el).find('ul li[class!=admin]').css('cursor', 'auto');
          });
        }
        if($(this).is('.insert-commodity-nav')){//開啟管理員新增商品
          $(insert_commodity.el).find('form').html('');
          $(insert_commodity.el).find('form').removeAttr('id');
          $(insert_commodity.el).find('form').attr('id','create_book_form');
          $(insert_commodity.el).find('form').attr('action','admin/create_book.php');
          $(insert_commodity.el).find('h2').html('新增商品');
          $('#create_book_form').append(insert_commodity_item_template_compile);
          $(insert_commodity.el).addClass('open');
        }
        if($(this).is('.update-member-admin-nav')){//開啟管理員修改會員資料
          $(update_member_admin.el).addClass('open');
          $(update_member_admin.el).find('ul').html('');
          $.post("admin/admin_update_commodity_data.php",function (data, textStatus, jqXHR) {
            admin_update_commodity_data_UI='';
            $.each(data.data, function (index, datas) {
              admin_update_commodity_data_UI = admin_update_commodity_data_UI + admin_update_commodity_data_template_compile(datas);
            });
            $(update_member_admin.el).find('ul').append(admin_update_commodity_data_UI);
          });
        }
        if($(this).is('.sign-out')){//登出
          $.post("signup_login/sign-out.php");
          window.location.reload();
        }
        if($(this).is('.shopping-list-admin-nav')){//開管理員購物清單
          $(shopping_list_admin.el).addClass('open');
          $(shopping_list_admin.el).find('ul').html('');
          $.post("admin/shopping_list_admin.php",function (data, textStatus, jqXHR) {
              var shopping_list_item_UI ='';
              $.each(data.data, function (index, datas) { 
                shopping_list_item_UI = shopping_list_item_UI + shopping_list_item_template_compile(datas);
              });
              $(shopping_list_admin.el).find('ul').append(shopping_list_item_UI);
          });
        }
    })
    .on('click', '.close', function(e){   //關閉視窗處理
        e.preventDefault();
        $(this).closest(signup.el).removeClass('open');//關閉註冊
        $(this).closest(login.el).removeClass('open');//關閉登入
        $(this).closest(signu_success.el).removeClass('open');//關閉訊息狀態
        $(this).closest(update_member.el).removeClass('open');//關閉修改會員資料
        $(this).closest(shopping_list.el).removeClass('open');//關閉購物清單
        $(this).closest(commodity_list.el).removeClass('open');//關閉商品書單清單
        $(this).closest(commodity_list.el).find('.container').html('');//關閉商品書單清單的重置所有資料
        $(this).closest(insert_commodity.el).removeClass('open');//關閉新增商品
        $(this).closest(insert_commodity.el).find('img').removeClass('open');//關閉上傳圖片的名字
        $(this).closest(update_member_admin.el).removeClass('open');//關閉管理員修改會員資料
        $(this).closest(shopping_list_admin.el).removeClass('open');//關閉管理員購物清單
        public_signup_login.alert_msg_off();//關閉視窗訊息
    })
    .on('click','#update-member .Menu li a', function(e) {//會員修改資料切換(修改資料，修改密碼)
      $('#update-member').find('.content li').hide();
      $($(this).attr('href')).show();
      $('.curren').removeClass('curren');
      $(this).addClass('curren');
      return false;
    })
    .on('click', '#update-member-admin ul li', function(e) {//管理員選擇修改資料
      e.preventDefault();
      var id = $(this).data('id');
      $(this).closest('ul').html('');
      $.post("admin/admin_update_commodity.php", {id:id},
        function (data, textStatus, jqXHR) {
          var admin_update_commodity ={
            id: data.id,
            name: data.name,
            email: data.email
          };
          var admin_update_commodity_template = admin_update_commodity_template_compile(admin_update_commodity);
          $('#update-member-admin').find('ul').append(admin_update_commodity_template);
      });
    })
    .on('click', '#shopping-list-admin ul li.admin', function(e) {//管理員購物清單更改出貨狀態
      e.preventDefault();
      shopping_list_admin_status_num++;
      var shopping_list_admin_status;
      var id = $(this).data('id');
      if(shopping_list_admin_status_num==1){
        shopping_list_admin_status='已出貨';
      }else if(shopping_list_admin_status_num==2){
        shopping_list_admin_status='未出貨';
        shopping_list_admin_status_num=0;
      }
      $(this).find('.shipment_status').html(shopping_list_admin_status);
      $.post("admin/update-shopping-list-admin-status.php", {id:id,shipment_status:shopping_list_admin_status},
        function (data, textStatus, jqXHR) {
          console.log(data.id);
          console.log(data.shipment_status);
      });
    })
    .on('click', '#update-member .content li#update-map .button', function(e) {//管理員選擇修改資料
      e.preventDefault();
      window.open('ecpay/sample_CvsMap.php', '電子地圖', config='height=800,width=1020');
    })
    .on('click', '#commodity-list div', function(e) {//修改商品
      e.preventDefault();
      if($(this).is('.update-commodity-button')){
        $(insert_commodity.el).find('form').html('');
        $(insert_commodity.el).find('h2').html('修改商品');
        $(insert_commodity.el).find('form').removeAttr('id');
        $(insert_commodity.el).find('form').attr('id','update_book_form');
        $(insert_commodity.el).find('form').attr('action','admin/update_book.php');
        var id =$(this).siblings('.container').find('.content').data('id');
        $.post("member/commodity_list.php", {id:id},
          function (data, textStatus, jqXHR) {
            $(insert_commodity.el).find('img')
            .attr('src',data.img)
            .addClass('open');
            $('#update_book_form').append(update_commodity_item_template_compile(data));
        });
        $('#create_book_form').find('.button').attr('value','修改');
        $(commodity_list.el).removeClass('open');
        $(insert_commodity.el).addClass('open');
      }
      if($(this).is('.delete-commodity-button')){//刪除商品
        var id =$(this).siblings('.container').find('.content').data('id');
        $.post("admin/delete_book_form.php", {id:id},
          function (data, textStatus, jqXHR) {
            $('#commodity .container ul').find(data.id).remove();
            $(commodity_list.el).removeClass('open');
            public_signup_login.alert_msg_success(data.data);
        });
      }
    })
    .on('change','#insert-commodity form .file_img', function(e){//預覽上傳圖片
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
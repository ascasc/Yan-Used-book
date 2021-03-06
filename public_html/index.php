<?php include('header.php'); ?>
<?php include('data/login_status.php');?>
<?php include('data/commodity_data.php');?>
<?php include('data/shopcart_data.php');?>
<div id="panel">
  <div id="header" class="clearfix">
    <div class="logo">Y</div>
    <nav class="clearfix">
      <ul class="nav">
        <!-- 以PHPsession來判斷登入與為登入的狀態 -->
        <li class="<?php if($login_status=='On'){echo 'shop-cart-nav';}else if($login_status=='Off'){echo 'login-nav';}?>">
          <?php if($login_status=='On'){echo '購物車';}else{echo '登入';}?>
        </li>
        <li class="<?php if($login_status=='On'){echo 'dropdown dropdown-toggle';}else if($login_status=='Off'){echo 'signup-nav';}?>">
          <?php if($login_status=='On'){echo '選單';}else if($login_status=='Off'){echo '註冊';}?>
          <ul class="dropdown-menu">
            <li>購物清單</li>
            <li>修改資料</li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- 此為購物車 -->
    <div id="shopcart-Panel">
      <!-- 此為購物車Template部分產生 -->
      
      <div class="container clearfix">
        <p>你的購物車是空的</p>
      </div>
      <div class="button">結帳</div>
    </div>
    <!-- 此為選單 -->
    <div id="Menu-Panel">
      <!-- 此為權限的設定 -->
      <li class="<?php if($login_level=='admin'){echo 'update-member-admin-nav';}else if($login_level=='member'){echo 'update-member-nav';}?>">
      <?php if($login_level=='admin'){echo '管理員修改會員資料';}else if($login_level=='member'){echo '修改會員資料';}?>
      </li> 
      <?php if($login_level=='admin'){?>
      <li class="insert-commodity-nav">新增商品</li> 
      <?php }?>
      <li class="<?php if($login_level=='admin'){echo 'shopping-list-admin-nav';}else if($login_level=='member'){echo 'shopping-list-nav';}?>">
      <?php if($login_level=='admin'){echo '管理員購物清單';}else if($login_level=='member'){echo '購物清單';}?>
      </li> 
      <?php if($login_level=='admin'){?>
      <li class="open-close-commodity-switch-nav">啟動與關閉未付費的商品</li> 
      <?php }?>
      <li class="sign-out">登出</li>
    </div>
  </div>
  <div id="slider">
    <img src="img/bg.jpeg" alt="bg.jpeg">
    <h1>歡迎來到 Yan二手書店</h1>
  </div>
  <!-- 此為登入系統 -->
  <?php if($login_status =='Off'){?>
  <div id="login" class="login-signup">
    <form id="login_form">
      <div class="close">x</div>
        <h3>Yan-二手書店登入</h3>
        <div class="error-msg">
			    <div class="alert alert-danger">error</div>
		    </div>
        <label>Email</label><br>
        <input type="email" name="email"><br>
        <label>密碼</label><br>
        <input type="password" name="password">
        <input type="submit" value="登入" class="button">
      <center><a href="#" onclick="window.open('forget_password.php', '忘記密碼', config='height=500,width=800');">忘記密碼?</a></center>
    </form>
  </div>
  <?php }?>
  <!-- 此為註冊資料 -->
  <?php if($login_status =='Off'){?>
  <div id="signup" class="login-signup">
    <form id="signup_form">
      <div class="close">x</div>
      <h3>Yan-二手書店註冊</h3>
      <div class="error-msg">
			  <div class="alert alert-danger">error</div>
		  </div>
      <label>姓名</label><br>
      <input type="text" name="name"><br>
      <label>Email</label><br>
      <input type="email" name="email"><br>
      <label>手機</label><br>
      <input type="text" name="phone"><br>
      <label>密碼</label><br>
      <input type="password" name="password">
      <label>確認密碼</label><br>
      <input type="password" name="two_password" class="two_password">
      <input type="submit" value="註冊" class="button">
    </form>
  </div>
  <?php }?>
  <!-- 此為修改個人資料 -->
  <?php if($login_level=='member'){?>
  <div id="update-member">
    <div class="close">x</div>
    <h3>修改會員資料</h3>
    <ul class="Menu clearfix">
      <li><a href="#update-data" class="curren">修改資料</a></li>
      <li><a href="#update-password">修改密碼</a></li>
      <li><a href="#update-map">修改寄貨門市</a></li>
    </ul>
    <ul class="content">
      <!-- 此為資料庫資料放入修改資料Template部分 -->
    </ul>
  </div>
  <?php }?>
  <!-- 此為管理員修改資料 -->
  <?php if($login_level=='admin'){?>
  <div id="update-member-admin">
    <div class="close">x</div>
    <h3>管理員修改會員資料</h3>
    <ul>
      <!-- 此為管理員購物清單Template部分產生 -->
    </ul>
  </div>
  <?php }?>
  <!-- 此為會員購物清單 -->
  <?php if($login_level=='admin'){?>
  <div id="shopping-list">
    <div class="close">x</div>
    <h2>購物清單</h1>
      <!-- 此為購物清單Template部分產生 -->
  </div>
  <?php }?>
  <!-- 此為insert到資料的commodity -->
  <?php if($login_level=='admin'){?>
  <div id="insert-commodity">
    <div class="close">x</div>
    <h2>新增商品</h2>
    <div class="error-msg">
		  <div class="alert alert-danger">error</div>
		</div>
    <img src="" alt="img1" class="img1"><br>
    <img src="" alt="img2" class="img2"><br>
    <form action="admin/create_book.php" enctype="multipart/form-data" id="create_book_form">
      <!-- 此為新增商品的Template部分 -->
    </form>
  </div>
  <?php }?>
  <?php if($login_level=='admin' || $login_level=='member'){?>
  <!-- 管理員與會員購物清單 -->
  <div id="shopping-list-admin">
    <div class="close">x</div>
    <h2>
      <?php if($login_level=='admin'){echo '管理員購物清單';}else if($login_level=='member'){echo '會員員購物清單';}?>
    </h2>
    <ul>
      <!-- 此為管理員購物清單Template部分產生 -->
      
    </ul>
  </div>
  <?php }?>
  <!-- 此為狀態訊息 -->
  <div id="signu-success">
    <p>註冊成功</p>
    <div class="button close">確定</div>
  </div>
  
  <!-- 此為商品書單 -->
  <div id="commodity">
    <!-- 商品清單 -->
    <div id="commodity-list"> 
     <div class="close">x</div><br>
     <?php if($login_status =='On' && $login_level =='member'){?><div class="button">加入購物車</div> <?php }?>
     <?php if($login_status =='On' && $login_level =='admin'){?><div class="update-commodity-button">修改商品</div> <?php }?><br>
     <?php if($login_status =='On' && $login_level =='admin'){?><div class="delete-commodity-button">刪除商品</div> <?php }?>
        <div class="container">
        <!-- 此為商品清單Template -->
        </div>
        
    </div>
    <em>商品書單</em>
    <div class="container clearfix">
      <ul class="row">
        <!-- 此為商品書單Template -->
      </ul>
    </div>
  </div>
  <!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v4.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your customer chat code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="102940757809757"
        theme_color="#67b868"
        logged_in_greeting="Hi,歡迎來到Yan二手書店,如有什麼問題歡迎諮詢."
        logged_out_greeting="Hi,歡迎來到Yan二手書店,如有什麼問題歡迎諮詢.">
  </div>
</div>
<!-- 導覽列判斷管理員與會員 -->
<script id="nav-Panel-item-template" type="text/x-handlebars-template">
  <li class="<?php if($login_status=='On'){echo 'shop-cart-nav';}else if($login_status=='Off'){echo 'login-nav';}?>">
    <?php if($login_status=='On'){echo '購物車';}?>
  </li>
  <li class="<?php if($login_status=='On'){echo 'dropdown dropdown-toggle';}else if($login_status=='Off'){echo 'signup-nav';}?>">
    <?php if($login_status=='On'){echo '選單';}else if($login_status=='Off'){echo '註冊';}?>
    <ul class="dropdown-menu">
      <li>購物清單</li>
      <li>修改資料</li>
    </ul>
  </li>
</script>
<!-- 商品書單Template部分 -->
<script id="commodity-item-template" type="text/x-handlebars-template">
{{#if switch_num}}
  <li class="col-4 {{commodity_id}}" data-id="{{commodity_id}}">
    <img src="{{img1}}" alt="{{img1}}">
    <div class="book-name">{{book_name}}</div>
    <div class="price">NT${{price}}</div>
  </li>
{{/if}}
</script>

<!-- 商品清單Template部分 -->
<script id="commodity-list-item-template" type="text/x-handlebars-template">
  <img src="{{img1}}" alt="{{img1}}">
  <img src="{{img2}}" alt="{{img2}}">
    <div class="content" data-id="{{id}}">
      <div class="book-name">{{book_name}}</div>
      <div class="author">作者：<span>{{author}}</span></div>
      <div class="Publishing-house">出版社：<span>{{Publishing_house}}</span></div>
      <div class="Publication-date">出版日期：<span>{{Publication_date}}</span></div>
      <div class="price">NT${{price}}</div><hr>
      <h4>內容簡介</h4><br>
      <div class="Introduction">{{Introduction}}</div><hr>
      <h4>作者介紹</h4><br>
      <div class="about_the_author">{{about_the_author}}</div><hr>
      <h4>目錄</h4><br>
      <div class="a_list">{{a_list}}</div><hr>
      <h4>詳細資料</h4><br>
      <div class="details">{{details}}</div>
    </div>
</script>

<!-- 購物車Template部分 -->
<script id="shopcart-Panel-item-template" type="text/x-handlebars-template">
  <li data-id="{{id}}">
    <img src="{{img1}}"" alt="{{img1}}">
    <div class="content">{{book_name}}</div>
    <div class="price">NT${{price}}</div>
    <div class="delete" data-id="{{id}}">刪除</div>
  </li>
</script>

<!-- 管理員購物清單Template部分 -->
<script id="shopping-list-item-template" type="text/x-handlebars-template"> 
  <li data-id={{product_id}} class="<?php if($login_level=='admin') echo 'product_status'; ?>">
  <!-- 未付款.未出貨.未收貨.已收貨Template部分 -->
    <em class="pay_status">{{pay_status}}</em>  
    <em class="shipment_status">{{shipment_status}}</em>  
    <span>{{book_name}}</span>
    <span>{{name}}</span>
    <span>{{phone}}</span>
    <span>{{email}}</span>
    <span>NT${{price}}</span>
    <span>{{CVSStoreID}}</span>
    <span>{{CVSAddress}}</span>
    <span>{{CVSStoreName}}</span>
  </li>
</script>

<!-- 此為選擇資料庫資料放入管理員修改資料Template部分 -->
<script id="admin-update-commodity-item-template" type="text/x-handlebars-template">
  <form id="admin-update-commodity-form">
    <input type="hidden" name="id" value="{{id}}">
    <label>姓名：</label><span>{{name}}</span>
    <label>Email：</label><input type="email" name="email" value="{{email}}">
    <input type="submit" value="修改" class="button">
  </form>
</script>

<!-- 此為資料庫資料放入管理員修改資料Template部分 -->
<script id="admin-update-commodity-data-item-template" type="text/x-handlebars-template">
  <li data-id="{{id}}">
    <label>姓名：</label><span>{{name}}</span>
    <label>Email：</label><span>{{email}}</span>
  </li>
</script>
<!-- 此為資料庫資料放入會員修改資料Template部分 -->
<script id="update-member-SQL-item-template" type="text/x-handlebars-template">
  <li id="update-data">
    <form id="update-data-form">
      <label>姓名:</label>&emsp;<input type="text" name="name" value="{{name}}"><br><br>
      <label>Email:</label>&ensp;<input type="email" name="email" value="{{email}}"><br><br>
      <label>手機:</label>&emsp;<input type="text" name="phone" value="0{{phone}}"><br><br>
      <input type="submit" value="修改資料" class="button">
    </form>
  </li>
  <li id="update-password">
    <form id="update-password-form">
      <label>目&ensp;前&ensp;密&ensp;碼:</label>&emsp;<input type="password" name="now_password"><br><br>
      <label>修&ensp;改&ensp;密&ensp;碼:</label>&emsp;<input type="password" name="password"><br><br>
      <label>確認修改密碼:</label>&ensp;&nbsp;<input type="password" name="two_password" class="two_password"><br><br>
      <input type="submit" value="修改密碼" class="button">
    </form>
  </li>
  <li id="update-map">
    <label>門市店號:</label><em>{{CVSStoreID}}</em><br><br>
    <label>門市名稱:</label><em>{{CVSStoreName}}</em><br><br>
    <label>門市地址:</label><em>{{CVSAddress}}</em>
    <div class="button">修改寄貨門市</div>
  </li>
</script>
<!-- 此為新增商品的Template部分 -->
<script id="insert-commodity-item-template" type="text/x-handlebars-template">
&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&ensp;&ensp;
      <input type="hidden" name="id"" value="{{id}}">
      <label>前封面圖片：</label>
      <input type="file" name="file_img1" class="file_img1" id="file_img1" accept="image/*"><br>
      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&ensp;&ensp;
      <label>後封面圖片：</label>
      <input type="file" name="file_img2" class="file_img2" id="file_img2" accept="image/*"><br>
      <label>書名：</label>&emsp;&ensp; 
      <input type="text" name="book_name"><br>
      <label>作者：</label>&emsp;&ensp; 
      <input type="text" name="author"><br>
      <label>出版社：</label>&ensp; 
      <input type="text" name="Publishing_house"><br>
      <label>出版日期：</label>
      <input type="date" name="Publication_date"><br>
      <label>價錢：</label>&emsp;&ensp;  
      <input type="text" name="price"><br>
      <label>簡介：</label><br>
      <textarea name="Introduction"></textarea><br><br>
      <label>作者介紹：</label><br>
      <textarea name="about_the_author"></textarea><br><br>
      <label>目錄：</label><br>
      <textarea name="a_list"></textarea><br><br>
      <label>詳細資料：</label><br>
      <textarea name="details" class="details"></textarea><br><br>
      <input type="submit" value="新增" class="button">
</script>
<!-- 此為更新商品的Template部分 -->
<script id="update-commodity-item-template" type="text/x-handlebars-template">
&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&ensp;&ensp;&ensp;
      <input type="hidden" name="id"" value="{{id}}">
      <label>前封面圖片：</label>
      <input type="file" name="file_img1" class="file_img1" id="file_img1" accept="image/*"><br>
      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&ensp;&ensp;&ensp;&emsp;
      <label>後封面圖片：</label>
      <input type="file" name="file_img2" class="file_img2" id="file_img2" accept="image/*"><br>
      <label>書名：</label>&emsp;&ensp; 
      <input type="text" name="book_name" value="{{book_name}}"><br>
      <label>作者：</label>&emsp;&ensp; 
      <input type="text" name="author" value="{{author}}"><br>
      <label>出版社：</label>&ensp; 
      <input type="text" name="Publishing_house" value="{{Publishing_house}}"><br>
      <label>出版日期：</label>
      <input type="date" name="Publication_date" value="{{Publication_date}}"><br>
      <label>價錢：</label>&emsp;&ensp;  
      <input type="text" name="price" value="{{price}}"><br>
      <label>簡介：</label><br>
      <textarea name="Introduction">{{Introduction}}</textarea><br><br>
      <label>作者介紹：</label><br>
      <textarea name="about_the_author">{{about_the_author}}</textarea><br><br>
      <label>目錄：</label><br>
      <textarea name="a_list">{{a_list}}</textarea><br><br>
      <label>詳細資料：</label><br>
      <textarea name="details" class="details">{{details}}</textarea><br><br>
      <input type="submit" value="更新" class="button">
</script>
<script id="open-close-commodity-switch-item-template" type="text/x-handlebars-template">
<li data-id={{commodity_id}} class="<?php if($login_level=='admin') echo 'commodity_switch'; ?>">
<!-- 開啟動與關閉未付費的商品Template部分 -->
  <span class="commodity_switch">{{switch}}</span>
  <span>{{book_name}}</span>
  <span>{{author}}</span>
  <span>NT${{price}}</span>
</li>
</script>
<?php include('footer.php'); ?>
<?php include('header.php'); ?>
<div id="panel">
  <div id="header" class="clearfix">
    <div class="logo">Y</div>
    <nav class="clearfix">
      <ul class="nav">
        <!-- 此為template產生 -->
      </ul>
    </nav>
    <div class="shopcart-Panel">
      <p>你的購物車是空的</p>
      <div class="button">結帳</div>
    </div>
    <div class="Menu-Panel">
      <li class="update-member-nav">修改會員資料</li>
      <li>購物清單</li>
      <li>登出</li>
    </div>
  </div>
  
  <div id="slider">
    <img src="img/bg.jpeg" alt="bg.jpeg">
    <h1>歡迎來到 Yan二手書店</h1>
  </div>
  <div id="login" class="login-signup">
    <form>
      <div class="close">x</div>
        <h3>Yan-二手書店登入</h3>
        <div class="error-msg">
			    <div class="alert alert-danger">error</div>
		    </div>
        <label>Email</label><br>
        <input type="email" name="email"><br>
        <label>密碼</label><br>
        <input type="password" name="password">
        <div class="button">登入</div><br>
      <center><a href="#">忘記密碼?</a></center>
    </form>
  </div>
  <div id="signup" class="login-signup">
    <form>
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
      <div class="button">註冊</div>
    </form>
  </div>

  <div id="update-member" class="login-signup">
    <form>
      <div class="close">x</div>
      <h3>修改會員資料</h3>
      <div class="error-msg">
			  <div class="alert alert-danger">error</div>
		  </div>
      <label>姓名：</label><label>顏章羽</label><br><br>
      <label>Email</label><br>
      <input type="email" name="email"><br>
      <label>手機</label><br>
      <input type="text" name="phone"><br>
      <label>密碼</label><br>
      <input type="password" name="password">
      <label>確認密碼</label><br>
      <input type="password" name="two_password" class="two_password">
      <div class="button">修改</div>
    </form>
  </div>
  <div id="signu-success">
    <p>註冊成功</p>
    <div class="button close">確定</div>
  </div>
</div>

<!-- navTemplate部分 -->
<script id="nav-item-template" type="text/x-handlebars-template">
  <li class="{{nav_li_1}}">{{nav_li_val_1}}</li>
  <li class="{{nav_li_2_1}} {{nav_li_2_2}}">{{nav_li_val_2}}
    <ul class="dropdown-menu">
        <li>購物清單</li>
        <li>修改資料</li>
      </ul>
  </li>
</script>

<!-- 購物車Template部分 -->
<script id="shopcart-Panel-item-template" type="text/x-handlebars-template">
  <li>
    <img src="http://lorempixel.com/50/50/" alt="">
    <div class="content">Infinite Power 濃縮乳清蛋白</div>
    <div class="price"><span>1</span>NT$<span>750</span></div>
    <div class="delete">刪除</div>
  </li>
</script>

<?php include('footer.php'); ?>

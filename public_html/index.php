<?php include('header.php'); ?>
<div id="panel">
  <div id="header" class="clearfix">
    <div class="logo">Y</div>
    <nav class="clearfix">
      <ul class="nav">
        <!-- 此為navTemplate產生 -->
      </ul>
    </nav>
    <!-- 此為購物車 -->
    <div id="shopcart-Panel">
      <p>你的購物車是空的</p>
      <!-- 此為購物車Template部分產生 -->
      <div class="button">結帳</div>
    </div>
    <!-- 此為選單 -->
    <div id="Menu-Panel"> 
      <!-- 此為管理員的選單Template部分 -->
      <!-- 或 -->
      <!-- 此為會員的選單Template部分 -->
    </div>
  </div>
  
  <div id="slider">
    <img src="img/bg.jpeg" alt="bg.jpeg">
    <h1>歡迎來到 Yan二手書店</h1>
  </div>
  <!-- 此為登入系統 -->
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
        <div class="button login">登入</div><br>
      <center><a href="#">忘記密碼?</a></center>
    </form>
  </div>
  <!-- 此為註冊資料 -->
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
      <div class="button signup">註冊</div>
    </form>
  </div>
  <!-- 此為修改個人資料 -->
  <div id="update-member" class="login-signup">
    <!-- 此為資料庫資料放入修改資料Template部分 -->
  </div>
  <!-- 此為管理員修改資料 -->
  <div id="update-member-admin">
    <div class="close">x</div>
    <h3>管理員修改會員資料</h3>
    <div class="error-msg">
      <div class="alert alert-danger">error</div>
    </div>
    <ul>
      <!-- 此為資料庫資料放入管理員修改資料Template部分 -->
    </ul> 
  </div>
  <!-- 此為購物清單 -->
  <div id="shopping-list">
    <div class="close">x</div>
    <h2>購物清單</h1>
      <!-- 此為購物清單Template部分產生 -->
      
  </div>
  <!-- 此為insert到資料的commodity -->
  <div id="insert-commodity">
    <div class="close">x</div>
    <h2>新增商品</h2>
    <form>
      <label>圖片：</label>
      <input type="file" name="img"><br>
      <label>書名：</label>
      <input type="text" name="book-name"><br>
      <label>作者：</label>
      <input type="text" name="author"><br>
      <label>出版社：</label>
      <input type="text" name="Publishing-house"><br>
      <label>出版日期：</label>
      <input type="date" name="Publication-date"><br>
      <label>價錢：</label>
      <input type="text" name="price"><br>
      <div class="button">新增</div>
    </form>
  </div>
  <!-- 此為狀態訊息 -->
  <div id="signu-success">
    <p>註冊成功</p>
    <div class="button close">確定</div>
  </div>
  <!-- 此為商品書單 -->
  <div id="commodity">
    <!-- 商品清單 -->
    <div id="commodity-list">
     <div class="close">x</div>
        <!-- 此為商品清單Template -->
    </div>
    <em>商品書單</em>
    <div class="container clearfix">
      <ul class="row">
        <li class="col-4 nb" data-id="">
          <img src="http://lorempixel.com/150/100/" alt="col-4">
          <div class="book-name">現代PHP新的特點及良好的習慣</div>
          <div class="price">NT$580</div>
        </li>
      </ul>
    </div>
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

<!-- 購物清單Template部分 -->
<script id="shopping-list-item-template" type="text/x-handlebars-template"> 
 <li>
 <!-- 分待付款.待出貨.待收貨.已完成Template部分 -->
    <em>{{status}}</em>  
    <img src="{{img}}" alt="{{img}}">
    <div class="book-name">{{book-name}}</div>
    <div class="price"><span>{{num}}</span>NT$<span>{{price}}</span></div>
  </li>
</script>

<!-- 商品書單Template部分 -->
<script id="commodity-item-template" type="text/x-handlebars-template">
  <li class="col-4" data-id="{{id}}">
    <img src="{{img}}}}" alt="{{img}}">
    <div class="book-name">{{book-name}}</div>
    <div class="price">NT${{price}}</div>
  </li>
</script>

<!-- 商品清單Template部分 -->
<script id="commodity-list-item-template" type="text/x-handlebars-template">
  <div class="container">
    <img src="{{img}}" alt="{{img}}">
    <div class="content">
      <div class="book-name">{{book-name}}</div>
      <div class="author">作者：<span>{{author}}}/span></div>
      <div class="Publishing-house">出版社：<span>{{Publishing-house}}</span></div>
      <div class="Publication-date">出版日期：<span>{{Publication-date}}</span></div>
      <div class="price">NT${{price}}</div>
      <div class="button">加入購物車</div>
    </div>
  </div>
</script>

<!-- 此為資料庫資料放入管理員修改資料Template部分 -->
<script id="update-member-admin-SQL-item-template" type="text/x-handlebars-template">
  <li data-id="{{id}}">
    <form>
      <label>姓名：</label><span>{{name}}</span>
      <label>Email：</label>
      <input type="email" name="email" value="{{email}}">
      <label>手機：</label>
      <input type="text" name="phone" value="{{phone}">
      <div class="button">修改</div>
    </form>
  </li>
</script>
<!-- 此為資料庫資料放入修改資料Template部分 -->
<script id="update-member-SQL-item-template" type="text/x-handlebars-template">
  <div class="close">x</div>
  <h3>修改會員資料</h3>
  <div class="error-msg">
		<div class="alert alert-danger">error</div>
  </div>
  <form>
    <label>姓名：</label><span>{{name}}</span><br><br>
    <label>Email</label><br>
    <input type="email" name="email" value="{{email}}"><br>
    <label>手機</label><br>
    <input type="text" name="phone" value="{{phone}}"><br>
    <div class="button">修改</div>
  </form>
</script>
<!-- 此為管理員與會員選單Template部分 -->
<script id="Menu-Panel-member-item-template" type="text/x-handlebars-template">
<!-- .update-member-admin-nav{管理員修改會員資料} -->
<!-- .insert-commodity-nav{新增商品} -->
<!-- .update-member-nav{修改會員資料} -->
<!-- .shopping-list-nav{購物清單} -->
  <li class="{{update-member-nav}}">{{update-member-content}}}</li> 
  <li class="{{insert-commodity-nav}}">{{insert-commodity-content}}</li>
  <li>登出</li>
</script>
<?php include('footer.php'); ?>
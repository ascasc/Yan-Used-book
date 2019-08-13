<?php include('header.php'); ?>
<div id="panel">
  <div id="header" class="clearfix">
    <div class="logo">Y</div>
    <nav class="clearfix">
      <ul>
        <li class="login-nav">登入</li>
        <li class="signup-nav">註冊</li>
      </ul>
    </nav>
  </div>
  <div id="slider">
    <img src="http://lorempixel.com/1200/1200/" alt="">
    <h1>歡迎來到 Yan二手書店</h1>
  </div>
  <div id="login" class="login-signup">
    <div class="close">x</div>
      <h3>Yan-二手書店登入</h3>
      <label>Email</label><br>
      <input type="email" class="email"><br>
      <label>密碼</label><br>
      <input type="password" class="password">
      <div class="button">
        <button>登入</button>
      </div>
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
      <input type="text" name="password">
      <label>確認密碼</label><br>
      <input type="password" name="two_password" class="two_password">
      <div class="button">
        <button>註冊</button>
      </div>
    </form>
    
  </div>
  <div id="signu-success">
    <p>註冊成功</p>
    <div class="button close">確定</div>
  </div>
</div>

<?php include('footer.php'); ?>

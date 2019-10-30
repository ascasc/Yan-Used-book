<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>重置密碼系統</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<br>
<center>
    <form action="reset_password_output.php" method="post">
        <label>Email:</label>&ensp;<label><?php echo $_GET['email'];?></label><br><br>
        <input type="hidden" name="password" value=<?php echo $_GET['password'];?>>
        <label>重 置 密 碼:</label> <input type="password" name="reset_password"><br><br>
        <label>確認重置密碼:</label> &nbsp;<input type="password" name="two_reset_password" class="two_password"><br><br>
        <input type="submit" value="重置密碼" class="button">
    </form>
</center>
<style>
.button{
  background: green;
  padding: 0 10px;
  border-radius: 10px;
  text-align: center;
  font-size: 20px;
  cursor: pointer;
}
.button:hover{
  color: white;
}
</style>
</body>
</html>
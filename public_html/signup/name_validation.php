<?php
include('signup_public.php');
if($_POST['name'] == $name_fetch['name']){
    msg_error('此姓名已存在');
}else{
    var_dump('此姓名可使用');
}
?>
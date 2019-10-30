<?php
session_start();
$login_status;
$login_level;
if(isset($_SESSION['customer'])){
    $login_status ='On';
    if($_SESSION['customer']['m_level'] == 'member'){
        $login_level ='member';
    }else{
        $login_level ='admin';
    }
}else if(!isset($_SESSION['customer'])){
    $login_status ='Off';
}
?>
<script>
    var login_status= <?= json_encode($login_status, JSON_NUMERIC_CHECK);?>;
</script>
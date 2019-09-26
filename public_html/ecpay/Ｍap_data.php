<?php
session_start();
include('../../../db.php');
try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}
$sql = 'INSERT INTO Map_data (CVSStoreID, CVSAddress, CVSStoreName, customer_data_id) 
VALUES(:CVSStoreID, :CVSAddress, :CVSStoreName, :customer_data_id)';
$statement = $pdo->prepare($sql);
$statement->bindValue(':CVSStoreID', $_POST['CVSStoreID'], PDO::PARAM_INT);
$statement->bindValue(':CVSAddress', $_POST['CVSAddress'], PDO::PARAM_STR);
$statement->bindValue(':CVSStoreName', $_POST['CVSStoreName'], PDO::PARAM_STR);
$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$result = $statement->execute();
if($result){
	echo '<div style="text-align:center;">匯入電子地圖成功。' .'<br><br>'.
	'<input onclick="window.close();" value="關閉視窗" type="button"></div>'.'<br>';
}else{
    var_dump($pdo->errorInfo());
}
?>
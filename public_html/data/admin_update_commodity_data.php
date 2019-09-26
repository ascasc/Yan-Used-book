<?php
include('../../db.php');


try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'SELECT * FROM customer_data ORDER BY id ASC';
$statement = $pdo->prepare($sql);
$statement->execute();
$admin_update_customer_datas= $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
	var admin_update_customer_datas = <?= json_encode($admin_update_customer_datas, JSON_NUMERIC_CHECK)?>;
</script>
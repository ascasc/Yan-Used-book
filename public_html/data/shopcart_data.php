<?php
include(realpath("./").'../../db.php');

try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'SELECT * FROM shopcart INNER JOIN commodity on commodity_id = commodity.id WHERE customer_data_id=:customer_data_id';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
	$result = $statement->execute();
	$shopcart = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
	var shopcart = <?= json_encode($shopcart, JSON_NUMERIC_CHECK)?>;
</script>
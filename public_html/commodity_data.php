<?php
include('../../db.php');


try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'SELECT * FROM commodity ORDER BY id ASC';
$statement = $pdo->prepare($sql);
$statement->execute();
$commodity = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
	var commodities = <?= json_encode($commodity, JSON_NUMERIC_CHECK)?>;
</script>
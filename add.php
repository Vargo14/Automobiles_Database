<?php
session_start();
require_once 'pdo.php';
if (isset($_POST['make'])) {
	$stmt = $pdo->prepare('INSERT INTO autos
  		(make, model, year, mileage, user_id) VALUES ( :mk, :md, :yr, :mi, :uid)');
	$stmt->execute(array(
			':mk' => $_POST['make'],
			':md' => $_POST['model'],
			':yr' => $_POST['year'],
			':mi' => $_POST['mileage'],
			'uid' => $_POST['user_id'])
	);
	$id = $pdo->query("SELECT LAST_INSERT_ID()");
	if (!$stmt) {
		echo json_encode([1, $id->fetch()[0]]);
	} else {
		echo json_encode([1, 0]);
	}
}

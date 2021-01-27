<?php
session_start();
require_once 'pdo.php';
if (isset($_POST['make'])) {
	$_SESSION['make'] = $_POST['make'];
	$stmt             = $pdo->prepare('UPDATE autos SET make = :make, model= :model, year= :year, mileage = :ma
								WHERE autos_id = :id');
	$stmt->execute([':make' => $_POST['make'],
			':model'              => $_POST['model'],
			':year'               => intval($_POST['year']),
			':ma'                 => intval($_POST['mileage']),
			':id'                 => intval($_POST['id'])
		]);
	if (!$stmt) {
		echo json_encode(0);

	} else {
		echo 1;
	}
}
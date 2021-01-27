<?php
require_once 'pdo.php';
$stmt = $pdo->query('DELETE FROM autos WHERE autos_id ='.$_POST['row']);
if (!$stmt) {
	echo 0;
} else {
	echo 1;
}

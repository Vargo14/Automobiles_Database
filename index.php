<?php
require_once "pdo.php";
session_start();
$name = '';
if (isset($_SESSION['id'])) {
	$name = $pdo->query('SELECT email FROM users WHERE user_id ='.$_SESSION['id'])->fetch(PDO::FETCH_ASSOC)['email'];
}

?>
<html>
<head>
    <title>Кемал Темилов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<body>
<div class='container'>
	<br>
	<h2>Welcome to the Automobiles Database <?=$name?></h2>
<?php
if (isset($_SESSION['id'])) {

	if (isset($_SESSION['error'])) {
		echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
		unset($_SESSION['error']);
	}
	if (isset($_SESSION['success'])) {
		echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
		unset($_SESSION['success']);
	}

	$stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos WHERE user_id =".$_SESSION['id']);

	if (!($rows = $stmt->fetchAll())) {
		echo "	<div class='alert' ><span class='alert alert-primary'>No rows found</span></div>";
		echo "	<button id='".$_SESSION['id']."' class='btn-add btn btn-success mx-2'>Add New Entry</button>
				<input class='btn btn-danger' type='submit' formaction='logout.php' value='Log out'>
				<div class='add-mes'></div>
				<div class='add-cont'></div>";
	} else {
		echo ('<div class="col-md-6"><table class="cars table table-light mb-2 mt-2" border="1">'."\n");
		foreach ($rows as $row) {
			echo "<tr id ='".$row['autos_id']."'><td id ='make".$row['autos_id']."'>";
			echo (htmlentities($row['make']));
			echo ("</td><td id ='model".$row['autos_id']."'>");
			echo (htmlentities($row['model']));
			echo ("</td><td id ='year".$row['autos_id']."'>");
			echo (htmlentities($row['year']));
			echo ("</td><td id ='mileage".$row['autos_id']."'>");
			echo (htmlentities($row['mileage']));
			echo ("</td><td>\n");
			echo ('<button class="edit btn btn-success mx-2" name="'.$row['autos_id'].'">Edit</button>'."\n");

			echo ('<button class="del btn btn-danger mx-2" name="'.$row['autos_id'].'">Delete</button>');
			echo ("</td></tr>\n");
		}

		echo "	</table></div><div class='error_mes'></div>
				<button id='".$_SESSION['id']."' class='btn-add btn btn-success mx-2'>Add New Entry</button>
				<a class='btn btn-danger'href='logout.php' value='Logout'>Log out</a>
				<div class='add-mes'></div>
				<div class='add-cont'></div>";

	}
} else {
	echo "<p><a href='login.php'>Please log in</a></p>";
}
?>

</div>
<script type="text/javascript" src="js/index_ajax.js"></script>
</body>
</html>
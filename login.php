<?php

session_start();
require_once 'pdo.php';
$salt = 'XyZzy12*_';

if (isset($_POST["email"]) && isset($_POST["pass"])) {
	$check = hash('md5', $salt.$_POST['pass']);
	$stmt  = $pdo->prepare("SELECT * FROM users WHERE email = :email and pass = :pass");
	$stmt->execute([':email' => $_POST['email'], ':pass' => $check]);
	if ($_POST['email'] === '' || $_POST['pass'] === '') {
		$error = 'User name and password are required';
	} elseif (!preg_match('/\w+@\w+\.\w/', $_POST['email'])) {
		$error = 'Email must have an at-sign (@)';
	} elseif ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		error_log("Login success ".$_POST['email']);
		$_SESSION['id'] = $row['user_id'];
		header("Location: index.php");
		return;
	} else {
		error_log("Login fail ".$_POST['email']." $check");
		$error = 'Incorrect password or email';
	}
	$_SESSION['error'] = $error;
	header('Location: login.php');
	return;
}
if (isset($_POST['reg_email']) && isset($_POST['reg_pass'])) {
	$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
	$stmt->execute([':email' => $_POST['reg_email']]);
	if ($stmt->fetch(PDO::FETCH_ASSOC)) {
		$error = 'This email already register';
	} elseif ($_POST['reg_email'] === '' || $_POST['reg_pass'] === '') {
		$error = 'User name and password are required';
	} elseif (!preg_match('/\w+@\w+\.\w/', $_POST['reg_email'])) {
		$error = 'Email must have an at-sign (@)';
	} else {
		$stmt = $pdo->prepare('INSERT INTO users(email, pass) values(:email, :pass)');
		if ($stmt->execute([':email' => $_POST['reg_email'], ':pass' => hash('md5', $salt.$_POST['reg_pass'])])) {
			$_SESSION['id'] = $pdo->lastInsertId();
			header("Location: index.php");
			return;
		}
	}
	$_SESSION['error'] = $error;
	header('Location: login.php');
	return;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Кемал Темилов</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<br>
		<h1 class="header">Please Log In</h1>
<?php
if (isset($_SESSION['error'])) {
	echo '<p style="color: red;">'.htmlentities($_SESSION['error']).'<p>';
	unset($_SESSION['error']);
}
?>
		<form method="POST" >

		<div class="email_form mb-4 mt-4">
			<label class="" for="nam">Email</label>
			<input class="email" type="text"  name="email" id="nam"><br/>
		</div>
		<div class="pass_form mb-4 mt-4">
			<label class="" for="id_1723">Password</label>
			<input class="pass" type="password"  name="pass" id="id_1723"><br/></div>
		<div class="subm-btn">
			<input class="subm-btn btn btn-success" type="submit" value="Log In"><br>
		</div>
	</form>

		<div class="changer">
			<button class="regist btn btn-primary mb-2 mt-2">Registration</button>
		</div>
</div>
<script type="text/javascript" src="js/login.js"></script>
</body>
</html>
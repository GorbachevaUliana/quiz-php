<?php
include "connection.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Result</title>
	<style>
	body{
		background-color: #665446;
		font-family:"Rubik"
	}
	
	.content{
		height:100%;
		width:50%;
		border-radius: 20px;
		background-color:#DEF2C4;
		margin-left:25%;
		margin-top: 10%;
		padding-top: 2%;
		text-align: center;
		padding-bottom: 2%;
	}
	img{
		border-radius:20px;
	}
	
	button{
		height:55px;
		width: 250px;
		border:none;
		background-color:#AECCB6;
		border-radius:20px;
		margin-top: 10px;
		cursor:pointer;
	}
	
	input{
		margin-top: 10px;
		background-color:#de8264;
		border: none;
		height:55px;
		width:250px;
		border-radius:20px;
		cursor:pointer;
	}
	</style>
</head>
<body>
<div class="content">
	<h1>Result</h1>
	<?php

	if (isset($_SESSION['name']) && isset($_SESSION['score'])) {
		$name = mysqli_real_escape_string($link, $_SESSION['name']);
		$score = $_SESSION['score'];
		$sql = "INSERT INTO users (name, score) VALUES (?, ?)";
		$stmt = mysqli_prepare($link, $sql);
		mysqli_stmt_bind_param($stmt, "si", $name, $score);
		mysqli_stmt_execute($stmt);
		if (mysqli_error($link)) {
			echo "<p style='color:red;'>Error saving score: " . mysqli_error($link) . "</p>";
		}

		echo "<p>Your score: " . $_SESSION['score'] . " from 10</p>";

	} else {
		echo "<p>An error occurred. Please try again.</p>";
	}

	mysqli_close($link);
	session_unset();
	session_destroy();

	?>
	<form method="post" action="demo.php">
		<input type="submit" value="Try again">
	</form>
	<form method="post" action="./api/index.html">
		<input type="submit" value="See info">
	</form>
</div>
</body>
</html>
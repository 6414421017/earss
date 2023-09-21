<?php
	require_once 'db_connect.php';
	$username = $_POST['username'];
	$password = $_POST['password'];

	$qry = $conn->query("SELECT * FROM users WHERE username = '$username' and  password = '$password'") or die(mysqli_error());
	$login = $qry->fetch_array();

	if($qry->num_rows > 0){
		echo true;
		session_start();
		foreach($login as $k => $v){
			if(!is_numeric($k) && $k !='password')
			$_SESSION['login_'.$k] = $v;
		}
	}

	$conn->close();
?>
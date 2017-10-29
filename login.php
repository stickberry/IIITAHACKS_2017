<?php
	session_start();

include 'dbh.php';

if (!$conn) {
 die(' Connection failed ');
}


$uid = mysqli_real_escape_string($conn, $_POST['uid']);
$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);


$stmt = $conn->prepare("SELECT * FROM user WHERE uid=?"); 
$stmt->bind_param("s", $username);

$username = $uid;
$stmt->execute();

$result = $stmt->get_result();
$rowNum = $result->num_rows; //number of rows

$row = mysqli_fetch_assoc($result);
$hash_pwd = $row['pwd'];
$hash = password_verify($pwd, $hash_pwd);

if($hash == 0) {

	echo "Username or password is incorrect!";
	header("Location: index.php?error=mismatch");
	exit();
}

$stmt = $conn->prepare("SELECT * FROM user where uid=? AND pwd=?"); 
$stmt->bind_param("ss", $username, $hash_pwd);
$stmt->execute();
$result = $stmt->get_result();


if(!$row = mysqli_fetch_assoc($result)) {

	//echo "Username or password is incorrect!";
	header("Location: index.php?error=mismatch1");
} else {
	$_SESSION['id'] = $row['id'];
	header("Location: user.php");
}

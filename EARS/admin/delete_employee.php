<?php
	require_once 'db_connect.php';
	$delete = $conn->query("DELETE FROM `employee` WHERE `id` = '".$_GET['id']."'") or die(mysqli_error());
	if($delete){
		echo json_encode(array("status"=>1,'msg'=>"ลบข้อมูลเรียบร้อย"));
	}
	$conn->close();
?>
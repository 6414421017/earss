<?php
	require_once 'db_connect.php';
	extract($_POST);
		$data = array();
		if(empty($id)){
			$chk = $conn->query("SELECT * FROM `users` WHERE `username` = '$username'")->num_rows;
			if($chk > 0){
				$data ['status'] = 2;
				$data['msg'] = 'มี Username นี้แล้ว';
			}else{
				$save=$conn->query("INSERT INTO users (username,password,firstname,lastname) values ('$username','$password','$firstname','$lastname')");
				if($save){
					$data ['status'] =1;
					$data['msg'] = 'บันทึกข้อมูลเรียบร้อย';
				}
			}
		}else{
			$chk = $conn->query("SELECT * FROM `users` WHERE `username` = '$username' and id != '$id' ");
			if($chk->num_rows > 0){
				$data ['status'] = 2;
				$data['msg'] = 'มี Username นี้แล้ว';
			}else{
				$save=$conn->query("UPDATE users set username = '$username',password = '$password',firstname = '$firstname',lastname = '$lastname' where id = $id ");
				if($save){
					$data ['status'] =1;
					$data['msg'] = 'บันทึกข้อมูลเรียบร้อย';
				}
			}
		}

		echo json_encode($data);
	$conn->close()	;

	?>
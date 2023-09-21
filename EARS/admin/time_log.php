<?php
include 'db_connect.php';
	extract($_POST);
	$data= array();
	$qry = $conn->query("SELECT * from employee where employee_no ='$eno' ");
	if($qry->num_rows > 0){
		$emp = $qry->fetch_array();
		$save_log= $conn->query("INSERT INTO attendance (log_type,employee_id) values('$type','".$emp['id']."')");
		$employee = ucwords($emp['firstname'].' '.$emp['lastname']);
		if($type == 1){
			$log = ' เข้าตอนเช้า';
		}elseif($type == 2){
			$log = ' ออกตอนเช้า';
		}elseif($type == 3){
			$log = ' เข้าตอนกลางคืน';
		}elseif($type == 4){
			$log = ' ออกตอนดลางคืน';
		}
		if($save_log){
				$data['status'] = 1;
				$data['msg'] = $employee .', คุณได้ลงบันทึก '.$log.' เรียบร้อยแล้ว. <br/>' ;
			}
	}else{
		$data['status'] = 2;
		$data['msg'] = 'ไม่มีรหัสพนักงานนี้';
	}
	echo json_encode($data);
	$conn->close();
?>
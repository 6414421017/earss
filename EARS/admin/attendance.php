<!DOCTYPE html>
<?php
	require_once 'auth.php';
?>
<html lang = "eng">
	<head>
		<title>Attendance | 8-12</title>
		<?php include('header.php') ?>
	</head>
	<body>
		<?php include('nav_bar.php') ?>
		<div class = "container-fluid admin" >
			<div class = "alert alert-primary">รายชื่อพนักงานลงบันทึกเวลาการทำงาน</div>
			<div class = "well col-lg-12">
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>รหัสพนักงาน</th>
							<th>ชื่อ</th>
							<th>Date</th>
							<th>บันทึกทำงาน</th>
							<th>เวลา</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$attendance_qry = $conn->query("SELECT a.*,concat(e.firstname,' ',e.middlename,' ',e.lastname) as name, e.employee_no FROM `attendance` a inner join employee e on a.employee_id = e.id ") or die(mysqli_error());
						while($row = $attendance_qry->fetch_array()){
							
					?>	
						<tr>
							<td><?php echo $row['employee_no']?></td>
							<td><?php echo htmlentities($row['name'])?></td>
							<td><?php echo date("d F, Y", strtotime($row['datetime_log']))?></td>
							<?php 
							if($row['log_type'] ==1){
								$log = "TIME-IN (AM)";
							}elseif($row['log_type'] ==2){
								$log = "TIME-OUT (AM)";
							}
							elseif($row['log_type'] ==3){
								$log = "TIME-IN (PM)";
							}elseif($row['log_type'] ==4){
								$log = "TIME-OUT (PM)";
							}
							?>
							<td><?php echo $log ?></td>
							<td><?php echo date("h:i a", strtotime($row['datetime_log']))?></td>
							<td><center><button data-id = "<?php echo $row['id']?>" class = "btn btn-sm btn-outline-danger remove_log" type="button"><i class = "fa fa-trash"></i></button></center></td>
						</tr>
					<?php
						}
					?>	
					</tbody>
				</table>
			</div>
		</div>
		
	</body>

	<script type = "text/javascript">
		$(document).ready(function(){
			$('.remove_log').click(function(){
				var id=$(this).attr('data-id');
				var _conf = confirm("คุณแน่ใจใช่ไหมที่จะลบข้อมูลนี้ ?");
				if(_conf == true){
					$.ajax({
						url:'delete_log.php?id='+id,
						error:err=>console.log(err),
						success:function(resp){
							if(typeof resp != undefined){
								resp = JSON.parse(resp)
								if(resp.status == 1){
									alert(resp.msg);
									location.reload()
								}
							}
						}
					})
				}
			});
		});
	</script>
</html>
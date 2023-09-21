<!DOCTYPE html>
<?php
	require_once 'auth.php';
?>
<html lang="eng">
	<head>
		<title>Employee | 8-12</title>
		<?php include('header.php') ?>
	</head>
	<body>
		<?php include('nav_bar.php') ?>
		
		<div class="container-fluid admin" >
			<div class="alert alert-primary">รายชื่อพนักงาน</div>
			<div class="well col-lg-12">
				<button class="btn btn-success" type="button" id="new_emp_btn"><span class="fa fa-plus"></span> Add new </button>
				<br />
				<br />
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>รหัสพนักงาน</th>
							<th>ชื่อ</th>
							<th>ชื่อกลาง</th>
							<th>นามสกุล</th>
							<th>แผนก</th>
							<th>ตำแหน่ง</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$employee_qry=$conn->query("SELECT * FROM employee") or die(mysqli_error());
							while($row=$employee_qry->fetch_array()){
						?>
						<tr>
							<td><?php echo $row['employee_no']?></td>
							<td><?php echo $row['firstname']?></td>
							<td><?php echo $row['middlename']?></td>
							<td><?php echo $row['lastname']?></td>
							<td><?php echo $row['department']?></td>
							<td><?php echo $row['position']?></td>
							<td>
								<center>
								 <button class="btn btn-sm btn-outline-primary edit_employee" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-edit"></i></button>
								<button class="btn btn-sm btn-outline-danger remove_employee" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i></button>
								</center>
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="modal fade" id="new_employee" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title" id="myModallabel">เพิ่มพนักงานใหม่</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='employee_frm'>
							<div class ="modal-body">
								<div class="form-group">
									<label>ชื่อ</label>
									<input type="hidden" name="id" />
									<input type="text" name="firstname" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>ชื่อกลาง</label>
									<input type="text" name ="middlename" placeholder="(optional)" class="form-control" />
								</div>
								<div class="form-group">
									<label>นามสกุล</label>
									<input type="text" name="lastname" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>แผนก</label>
									<input type="text" name="department" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>ตำแหน่ง</label>
									<input type="text" name="position" required="required" class="form-control" />
								</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span>บันทึก</button>
							</div>
						</form>
					</div>
				</div>
			</div>
	</body>

	<script type="text/javascript">
		$(document).ready(function(){

			$('#employee_frm').submit(function(e){
				e.preventDefault()
				$('#employee_frm [name="submit"]').attr('disabled',true)
				$('#employee_frm [name="submit"]').html('Saving')
				$.ajax({
					url:'save_employee.php',
					method:"POST",
					data:$(this).serialize(),
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							if(resp.status == 1){
								alert(resp.msg);
								location.reload();
							}
						}
					}
				})
			})

			$('.remove_employee').click(function(){
				var id=$(this).attr('data-id');
				var _conf = confirm("คุณแน่ใจใช่ไหมที่จะลบข้อมูลนี้ ?");
				if(_conf == true){
					$.ajax({
						url:'delete_employee.php?id='+id,
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
			$('.edit_employee').click(function(){
				var $id=$(this).attr('data-id');
				$.ajax({
					url:'get_employee.php',
					method:"POST",
					data:{id:$id},
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							$('[name="id"]').val(resp.id)
							$('[name="firstname"]').val(resp.firstname)
							$('[name="lastname"]').val(resp.lastname)
							$('[name="middlename"]').val(resp.middlename)
							$('[name="department"]').val(resp.department)
							$('[name="position"]').val(resp.position)
							$('#new_employee .modal-title').html('แก้ไขข้อมูลพนักงาน')
							$('#new_employee').modal('show')
						}
					}
				})
				
			});

			$('#new_emp_btn').click(function(){
				$('[name="id"]').val('')
				$('[name="firstname"]').val('')
				$('[name="lastname"]').val('')
				$('[name="middlename"]').val('')
				$('[name="department"]').val('')
				$('[name="position"]').val('')
				$('#new_employee .modal-title').html('เพิ่มพนักงานใหม่')
				$('#new_employee').modal('show')
			})
		});
	</script>
</html>
<?php
	require 'class/Db.php';
	$database = new Database();

?>
<html>
	<head>
		<title>PHP+OOPS+AJAX</title>
		<script src="https://ajax.googlepics.com/ajax/libs/jquery/2.2.0/jquery.min.s"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxdcn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style>
			body
			{
				margin:0;
				padding:0;
				back ground-color:#f1f1f1;
			}
			.box
			{
				width:1270px;
				padding:20px;
				background-color:#fff;
				border:1px solid #ccc;
				border-radius:5px;
				margin-top:100px;
			}
		</style>
	</head>	
	<body>
		<div class="container box">
		<h3 align="center">COLORFUL FLOWERS</h3><br>
		<button type="button" name="add" class="btn btn-success" data-toggle="collapse" data-target="#user_collapse">ADD</button> <br /><br />
		
		<div id="user_collapse" class="collapse">
			<form method="post" id="user_form">
				<label>ENTER THE NAME OF FLOWER</label>
				<input type="text" name="name" id="name" class="form-control" />
				<br />
				<label>ENTER THE COLOR OF FLOWER</label>
				<input type="text" name="color" id="color" class="form-control" />
				<br />
				<label>SELECT IMAGE</label>
				<input type="file" name="user_pic" id="user_pic" />
				<input type="hidden" name="hidden_pic" id="hidden_pic" />
				<span id="uploaded_pic"></span>
				<br />
				<div align="center">
					<input type="hidden" name="action" id="action" />
					<input type="hidden" name="user_id" id="user_id" />
					<input type="submit" name="button_action" id="button_action" class="btn btn-default" value="Insert" />
				</div>
			</form>
		</div>
		<div id="user_table" class="table-responsive">
		</div>
		</div>
	</body>
</html>	
<script type="text/javascript">
	$(document).ready(function()
	{
		load_data();
		$('#action').val("Insert");
		function load_data()
		{
			var action = "Load";
			$.ajax(
			{
				url:"action.php",
				method:"POST",
				data:{action:action},
				success:function(data)
				{
					$('#user_table').html(data);
				}
			});
		}
		$('#user_form').on('submit', function(event)
		{
			event.preventDefault();
			var name = $('#name').val();
			var color = $('#color').val();
			var extension = $('#user_pic').val().split('.').pop().toLowerCase();
			if(extension != '')
			{
				if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
				{
					alert("Invalid image file");
					$('#user_pic').val('');
					return false;
				}
			}
			if(name != '' && color != '')
			{
				$ajax(
				{
					url:"action.php",
					method:"POST",
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data)
					{
						alert(data);
						$('#user_form')[0].reset();
						load_data();
						$("action").val("Insert");
						$('#button_action').val("Insert");
						$('#uploaded_pic').html('');
					}
				})
			}
					
			}
			else
			{
				alert("Fields are empty");
			}
		});
		$(document).on('click','.update',function()
		{
			var user_id =$(this).attr("id");
			var action = "Fetch Single Data";
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{user_id:user_id, action:action},
				dataType:"json",
				success:function(data)
				{
					$('.collapse').collapse("show");
					$('#name').val(data.name);
					$('#color').val(data.color);
					$('#uploaded_pic').html(data.pic);
					$('#hidden_user_pic').val(data.user_pic);
					$('#button_action').val("Edit");
					$('#action').val("Edit");
					$('#user_id').val(user_id);
				}
			})
		});
</script>
			
			

 
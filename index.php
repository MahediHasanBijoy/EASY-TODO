<?php 
	require_once("./db.inc.php");

	$sql = "SELECT * FROM `task`";
	$result = $db->query($sql);
	if ($db->error) {
		exit("SQL error");
	}
/*	$array = $result->fetch_array();
	$result->free();*/
	if (isset($_POST['submit'])) {
		$todo  = $_POST['todo'];
		date_default_timezone_set('Asia/Dhaka');
		$date = date("l jS \ F Y h:i:s A",time());
		$sql = "INSERT INTO task SET `t_name`='{$todo}', `t_date`='{$date}'";
		$results = $db->query($sql);
		if($db->error){
			exit("SQL error");
		}
		if (!$results) {
			die("Failed");
		}else{
			header("Location:index.php?todo-added");
		}
	}
 ?>



<!DOCTYPE html>
<html>
	<head>
		<title>EASY TODO</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<style>
			.todo{
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
				border-radius: 3px;
				border: 1px solid #cccccc;
				margin-top: 5px;

			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="todo">
				<h1>EASY TODO</h1>
				<h3>Add a New Todo</h3>
				<form action="#" method="post">
					<div class="form-group">
						<input class="form-control" type="text" name="todo" placeholder="Todo Name">
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" name= "submit" value="Add a New Todo Task"></input>
					</div>
				</form>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<th>ID</th>
						<th>Todo</th>
						<th>Date</th>
						<th>Edit</th>
						<th>Delete</th>
					</thead>
					<tbody>
						<?php 
							while($row = $result->fetch_array()){
								$t_id = $row['t_id'];
								$t_name = $row['t_name'];
								$t_date = $row['t_date'];
							
						 ?>
						<tr>
							<td><?php echo $t_id; ?></td>
							<td><?php echo $t_name; ?></td>
							<td><?php echo $t_date; ?></td>
							<td><a href="#" class="btn btn-primary">Edit </a></td>
							<td><a href="#" class="btn btn-danger">Delete</a></td>
						</tr> 
						 <?php 
						}
						//Free result set
						$result->free();
						//Close the database
						$db->close();

						  ?>
						
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>

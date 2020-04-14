<?php 
	require_once("./db.inc.php");
	require_once('controllers/authController.php');
	
	// verify the user using token
	if (isset($_GET['token'])) {
		$token = $_GET['token'];
		verifyUser($token);

	}

	// verify the user using token
	if (isset($_GET['password-token'])) {
		$passwordToken = $_GET['password-token'];
		resetPassword($passwordToken);

	}

	if (!isset($_SESSION['id'])) {
		header('location: login.php');
		exit();
	}

	$sql = "SELECT * FROM `task` WHERE `user_id`='{$_SESSION['id']}'";
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
		if(empty($todo)){
			$error = "YOU MUST ADD A TODO";
		}else{
			$sql = "INSERT INTO task SET `t_name`='{$todo}', `t_date`='{$date}', `user_id`='{$_SESSION['id']}'";
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
	}
	if (isset($_GET['delete_todo'])) {
		$dtl_todo = $_GET['delete_todo'];
		$sql = "DELETE FROM `task` WHERE `t_id`='{$dtl_todo}'";
		$result2= $db->query($sql);
		if ($db->error) {
			exit("SQL error");
		}
		if (!$result2) {
			die("Failed");
		}else{
			header("Location:index.php?todo-deleted");
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
				background-color: aqua;


			}
			h1{
				color: navy;
			}
			.search{
				margin: 5px;
			}
			
		</style>
	</head>
	<body>
		<div class="container">
			<div class="todo">
				<h1>EASY TODO</h1>
				<h3>Add a New Todo</h3>
				<?php 
					if (isset($error)) {
						echo "<div class='alert alert-danger'>$error</div>";
					}
				 ?>
				<form action="#" method="post">
					<div class="form-group">
						<input class="form-control" type="text" name="todo" placeholder="Todo Name">
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" name= "submit" value="Add a New Todo Task"></input>
					</div>
				</form>
			</div>
			<div class="col-lg-4 search">
				<form action="search.php" method="post">
					<input class="form-control" type="text" name="search" placeholder="Search Todo">
				</form>
			</div>
			<div class="table-responsive col-lg-12">
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
						$i=1;
							while($row = $result->fetch_array()){
								
								$serial = $i;
								$i++;
								$t_id = $row['t_id'];
								$t_name = $row['t_name'];
								$t_date = $row['t_date'];
							
						 ?>
						<tr>
							<td><?php echo $serial; ?></td>
							<td><?php echo $t_name; ?></td>
							<td><?php echo $t_date; ?></td>
							<td><a href="edit.php?edit-todo=<?php echo $t_id; ?>" class="btn btn-primary">Edit </a></td>
							<td><a href="index.php?delete_todo=<?php echo $t_id; ?>" class="btn btn-danger">Delete</a></td>
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
				<a href="index.php?logout=1" class="btn btn-primary">Log out </a>
			</div>

		</div>

	</body>
</html>

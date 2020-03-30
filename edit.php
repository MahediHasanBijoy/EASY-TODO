<?php 
	require_once("./db.inc.php");
	
	if(isset($_GET['edit-todo'])){
		$e_id = $_GET['edit-todo'];

	}
	if (isset($_POST['edit_todo'])) {
		$edit_todo = $_POST['todo'];

		$sql = "UPDATE `task` SET `t_name`='{$edit_todo}' WHERE `t_id`='{$e_id}'";
		$result3= $db->query($sql);
		if($db->error){
			exit("SQL error");
		}
		if (!$result3) {
			die("Failed to edit");
		}else{
			header("Location:index.php?updated");
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
		</style>
	</head>
	<body>
		<div class="container">
			<div class="todo">
				<h1>EASY TODO</h1>
				<h3>Edit Todo</h3>
				<form action="" method="post">
					<?php 
						$sql = "SELECT * FROM `task` WHERE `t_id`='{$e_id}'";
						$result = $db->query($sql);
						if ($db->error) {
							exit("SQL error");
						}
						$data = $result->fetch_array();

					 ?>
					<div class="form-group">
						<input class="form-control" type="text" name="todo" placeholder="Todo Name" value="<?php echo $data['t_name']; ?>">
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" name= "edit_todo" value="Save"></input>
					</div>
				</form>
			</div>	
		</div>
	</body>
</html>

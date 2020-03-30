<?php 
	require_once("./db.inc.php");
		
	if (isset($_POST['search'])) {
		$search = $_POST['search'];
		$sql = "SELECT * FROM `task` WHERE `t_name` LIKE '%$search%'";
		$result = $db->query($sql);
		if ($db->error) {
			exit("SQL error");
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
				<h1><a href="index.php">Easy Todo</a></h1>
				<h3>Add a New Todo</h3>
				
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
							if ($result->num_rows===0) {
								echo "<tr>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td><h1>No Results Found</h1></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "</tr>";
							}
							while($row = $result->fetch_array()){
								$t_id = $row['t_id'];
								$t_name = $row['t_name'];
								$t_date = $row['t_date'];
							
						 ?>
						<tr>
							<td><?php echo $t_id; ?></td>
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
			</div>
		</div>
	</body>
</html>

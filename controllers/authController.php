<?php
session_start();
require('./db.inc.php');
require_once('./controllers/emailController.php');


$errors = array();
$username = "";
$email = "";


// if user clicks on the sign up button
if (isset($_POST['signup-btn'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordConf = $_POST['passwordConf'];

	//validation
	if (empty($username)) {
		$errors['username'] = "Username required";
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email']= "Email address is invalid";
	}
	if (empty($email)) {
		$errors['email'] = "Email required";
	}
	if (empty($password)) {
		$errors['password'] = "Password required";
	}

	if ($password !== $passwordConf) {
		$errors['password'] = "The two password do not match"; 
	}

	$sql = "SELECT * FROM users WHERE u_email=? LIMIT 1";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('s',$email);
	$stmt->execute();
	$result = $stmt->get_result();
	$userCount = $result->num_rows;

	if ($userCount > 0) {
		$errors['email']="Email already exists";
	}
	if (count($errors)===0) {
		$password  = password_hash($password, PASSWORD_DEFAULT);
		$token = bin2hex(random_bytes(50));
		$verified = false;

		$sql2 = "INSERT INTO users (u_name, u_email, u_verified, u_token , u_password) VALUES (?,?,?,?,?) ";
		$stmt = $db->prepare($sql2);
		$stmt->bind_param('ssbss',$username,$email,$verified,$token,$password);
		if($stmt->execute()){
			//login user
			$user_id = $db->insert_id;
			$_SESSION['id']= $user_id;
			$_SESSION['username']= $username;
			$_SESSION['email']= $email;
			$_SESSION['verified']= $verified;

			// function for sending verification email to the user
			sendVerificationEmail($email, $token);

			// set flash message
			$_SESSION['message']= "You are now logged in";
			$_SESSION['alert_class'] = "alert-success";
			header("location:homepage.php");
			exit();

		}else{
			$errors['db_error']="Database error: failed to register";
		}



	}

}


// if user clicks on the login button
if (isset($_POST['login-btn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	

	//validation
	if (empty($username)) {
		$errors['username'] = "Username required";
	}
	if (empty($password)) {
		$errors['password'] = "Password required";
	}

	if (count($errors)===0) {
		$sql = "SELECT * FROM users WHERE u_email=? OR u_name=? LIMIT 1";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('ss',$username, $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();

		if (password_verify($password, $user['u_password'])) {
			//login success
				$_SESSION['id']= $user['u_id'];
				$_SESSION['username']= $user['u_name'];
				$_SESSION['email']= $user['u_email'];
				$_SESSION['verified']= $user['u_verified'];
				// set flash message
				$_SESSION['message']= "You are now logged in";
				$_SESSION['alert_class'] = "alert-success";
				header("location:index.php");
				exit();
		}else{
			$errors['login_fail'] = "Wrong credentials";
		}
	}

}



// logout user
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['id']);
	unset($_SESSION['username']);
	unset($_SESSION['email']);
	unset($_SESSION['verified']);
	header('location: login.php');
	exit();
}


// verify user by token
function verifyUser($token){
	global $db;
	$sql = "SELECT * FROM users WHERE u_token='$token' LIMIT 1";
	$result = $db->query($sql);
	if ($db->error) {
		exit("Sql error");
	}
	if ($result->num_rows > 0) {
		$user = $result->fetch_array();
		$update_query = "UPDATE users SET u_verified=1 WHERE u_token='$token'";
		if ($db->query($update_query)) {
			//log user in

			$_SESSION['id']= $user['u_id'];
			$_SESSION['username']= $user['u_name'];
			$_SESSION['email']= $user['u_email'];
			$_SESSION['verified']= 1;

			// function for sending verification email to the user
			sendVerificationEmail($email, $token);

			// set flash message
			$_SESSION['message']= "Your email address was successfully verified";
			$_SESSION['alert_class'] = "alert-success";
			header("location:homepage.php");
			exit();
		}

	}else{
		echo 'User not found';
	}

}


// if user clicks on the forgot password button
if (isset($_POST['forgot-password'])) {
	$email = $_POST['email']; 

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email']= "Email address is invalid";
	}
	if (empty($email)) {
		$errors['email'] = "Email required";
	}

	if (count($errors)== 0) {
		$sql = "SELECT * FROM users WHERE u_email='$email' LIMIT 1";
		$result = $db->query($sql);
		if ($db->error) {
			exit('SQL error!');
		}
		$user = $result->fetch_assoc();
		$token = $user['u_token'];
		sendPasswordResetLink($email,$token);
		header('location: password_message.php');
		exit();
	}
	
}

// if user clicked on the reset password button
if (isset($_POST['reset-password-btn'])) {
	$password = $_POST['password'];
	$passwordConf = $_POST['passwordConf'];
	if (empty($password)||empty($passwordConf)) {
		$errors['password'] = "Password required";
	}

	if ($password !== $passwordConf) {
		$errors['password'] = "The two password do not match"; 
	}

	$password = password_hash($password, PASSWORD_DEFAULT);
	$email = $_SESSION['email'];
	if (count($errors)==0) {
		$sql = "UPDATE users SET u_password='$password'  WHERE u_email='$email'";
		$result = $db->query($sql);
		if($db->error){
			exit('SQL error');
		}
		if ($result) {
			header('location: login.php');
			exit(0);
		}

	}
}

// function for reset password
function resetPassword($token){
	global $db;
	$sql = "SELECT * FROM users WHERE u_token='$token' LIMIT 1";
	$result = $db->query($sql);
	if($db->error){
		exit('SQL error!');
	}
	$user = $result->fetch_assoc();
	$_SESSION['email'] = $user['u_email'];
	header('location: reset_password.php');
	exit(0);

}
<?php 

include('classes/db.php');

if(isset($_POST['createaccount'])) {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	if(!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

		if(strlen($username) >= 3 && strlen($username) <= 32) {

			// regex to check for username
			if(preg_match('/[a-zA-A0-9]+/', $username)) {

				if(strlen($password) >= 6 && strlen($password) <= 60) {


				// email validation
				if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
					if(!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {
						DB::query('insert INTO users VALUES(\'\', :username, :password, :email, \'0\')', array(':username'=>$username, 
							':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));
						echo "Success";		
					} else {
						echo "Email in use";
					}

						
				} else {
					echo 'Invalid email';
				}

			} else {
				echo "Invalid password";
			}

				
			}
			
		} else {
			echo "Invalid username";
		}

		
	} else {
		echo "User already exists!";
	}
	
		
	
	
}
 ?>

<html>
<body>
	<h1>Register</h1>
	<form action="create-account.php" method="post">
		<input type="text" placeholder="username" name="username"> <br>
		<input type="password" placeholder="password" name="password"> <br>
		<input type="text" placeholder="email" name="email"> <br>
		<input type="submit" name="createaccount" value="Create Account"> 
	</form>
	
</body>
</html>
 
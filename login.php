<?php 
include('classes/db.php');
if(isset($_POST['login'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

		if(password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', 
		array(':username'=>$username))[0]['password'])) {
			// echo "logged in";

			$cstrong = true;
			$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

			
			$user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];

			
			DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), 
				':user_id'=>$user_id));

			// 5th item => "NULL" - if HTTPS, this would be true
			// 6th item => HTTP Only (means that JS can't access this cookie)
			setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
			setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);



		} else {
			echo "Incorrect password";
		}

	} else {
		echo "User not registered";
	}
}

 ?>
<h1>Login to your account</h1>
<form action="login.php" method="post">
	<input type="text" name="username" value="" placeholder="Username"><br>
	<input type="password" name="password" value="" placeholder="Password"><br>
	<input type="submit" name="login" value="Login">
</form>
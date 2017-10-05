<?php 

include('./classes/db.php');
include('./classes/login.php');
$tokenIsValid = false;
 if(login::isLoggedIn()) {
 	
 	if(isset($_POST['changepassword'])) {

 		$oldpassword = $_POST['oldpassword'];
 		$newpassword = $_POST['newpassword'];
 		$newpassword2 = $_POST['newpassword2'];
 		$userid = login::isLoggedIn();

 		if(password_verify($oldpassword, DB::query('SELECT password FROM users WHERE id=:userid', 
 		array(':userid'=>$userid))[0]['password'])) {

 			if($newpassword == $newpassword2) {

 				if(strlen($newpassword) >= 6 && strlen($newpassword) <= 60) { 

 					DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));

 					echo 'Password changed Successfully';
 				}

 			} else {
 				echo "Passwords don't match!";
 			}

 		} else {
 			echo 'Incorrect old password!';
 		}


 	}

 } else {
 		
        if (isset($_GET['token'])) {
        $token = $_GET['token'];
        if (DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))) {
                $userid = DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                $tokenIsValid = true;
                if (isset($_POST['changepassword'])) {
                        $newpassword = $_POST['newpassword'];
                        $newpasswordrepeat = $_POST['newpassword2'];
                                if ($newpassword == $newpasswordrepeat) {
                                        if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
                                                DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                                echo 'Password changed successfully!';
                                                DB::query('DELETE FROM password_tokens WHERE user_id=:userid', array(':userid'=>$userid));
                                        }
                                } else {
                                        echo 'Passwords don\'t match!';
                                }
                        }
        } else {
            die('Token invalid');
        }
} else {
        die('Not logged in');
}
}








 ?>

<h1>Change Your Password</h1>
<form action="<?php if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?token='.$token.''; } ?>" method="post">
	<?php if (!$tokenIsValid) { echo '<input type="password" name="oldpassword" value="" placeholder="Current Password ..."><p />'; } ?>
	<input type="password" name="newpassword" value="" placeholder="New Password"><p />
	<input type="password" name="newpassword2" value="" placeholder="Repeat New Password"><p />
	<input type="submit" name="changepassword" value="Change Password">
</form>
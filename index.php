<?php 

include('./classes/db.php');
include('./classes/login.php');

 if(login::isLoggedIn()) {
 	echo "logged in";
 	echo login::isLoggedIn();
 } else {
 	echo "Not logged in";
 }








 ?>

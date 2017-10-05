<?php 

// create database

// create users table
/*

CREATE TABLE `Social_Network`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(80) NULL,
  `email` VARCHAR(200) NULL,
  PRIMARY KEY (`id`));

*/

// General Authentication / Authorization Steps
/*

1. Build tables => users and login_tokens

2. Account Creation
	- username => minimum and maximum lengths, unique username
	- password => minimum and maximum lengths
	- email => valid email, unique email

3. Login Process
	- Check Password
		- Get user from database
		- user password_verify() to confirm given password matches hashed password
		- if match, next step...
	- Issue Token
		- Create token of random bits, length of 64
		- Get user ID of user given their username
		- Insert into login_tokens: 
			- the hashed token (using sha1)
			- user ID
		- Set cookies: one main authorization cookie and one cookie to "reset" your cookie every few days
			- setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE); => REAL COOKIE
			- setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE); => the "Reset" cookie

4. Checking Login Status (isLoggedIn())
	- Check SNID cookie
		- get value of cookie and search for it in the database
	- Check SNID_ cookie
		- SNID_ has a shorter life; if not there, delete old token and insert new one
	- isLoggedIn() => returns user_id OR false (if not logged in)

5. Logging out
	- You can log out of all devices or just your current device (I don't see many services 
	offering logout from all devices anymore)
	- You are essentially deleting the login token

6. Change Password

7. Forgot Password
















*/  




 ?>




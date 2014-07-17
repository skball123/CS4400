<?php
//HTML code
include("configuration.php");
//SQL credentials
/*
	Get Username POST data
*/
if(isset($_POST['myusername'])) {
	$myusername=$_POST['myusername'];
} else {
	die("$registration_redirect Please enter your username <br /> $registration_back_button </body></html>"); //Redirect, error message, back button
}

/*
	Get Password POST data
*/
if(isset($_POST['mypassword'])) {
	$mypassword=$_POST['mypassword'];
} else {
	die("$registration_redirect Please enter your password <br /> $registration_back_button </body></html>"); //Redirect, error message, back button
}
/*
	Connecting to MySQL database
*/
$link = mysqli_connect($host, $username, $password, $database) or die ("ERROR, could not establish connection to database in check_login.php, please contact the webmaster");
/*
	Force charset to UTF8 for security purposes
*/
if (!mysqli_set_charset($link, "utf8"))
    printf("Error loading character set utf8: %s\n", mysqli_error($link));

/*
	Prevent SQL injection
*/
$myusername = mysqli_real_escape_string($link, $myusername);
$mypassword = mysqli_real_escape_string($link, $mypassword);
 $saltedhash = md5($mypassword); //our passwords are md5 hashed
/*
	Authenticate user
*/
$sql = "SELECT GT_ID, Password, User_Type FROM $passwordtable WHERE GT_ID='$myusername' AND Password='$saltedhash'";
$result=mysqli_query($link,$sql) or die(mysqli_error($link));
$count=mysqli_num_rows($result);
$row = mysqli_fetch_row($result);
if($count==1) {
	//echo("validated");
	//Start Session and Store username/password
	session_start();
	$_SESSION['myusername']=$myusername;
	$_SESSION['mypassword']=$mypassword;
	$type = $row[2];
	//echo($type);
	$_SESSION['type']=$type;
	
	switch($type) {
		case "STU":
			header("location:$redirectURL_STU");
			echo("STU redirect");
			break;
		case "TUT":
			header("location:$redirectURL_TUT");
			echo("TUT redirect");	
			break;
		case "PRO":
			header("location:$redirectURL_PRO");
			echo("PRO redirect");
			break;		
		case "ADM":
			header("location:$redirectURL_ADM");
			echo("ADM redirect");
			break;
	}
	
} else {
	echo('
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
		<html>
		<head>
		<meta http-equiv="REFRESH" content="3;url=http://samkirsch.net/cs4400"></HEAD>
		<BODY>
		Invalid/ wrong GTID or password... <br> Please try again. You will be redirected in 3 seconds.
		</BODY>
		</HTML>');
}
/*
	Done with MySQL, closing connection
*/
$thread_id = mysqli_thread_id($link);
mysqli_kill($link, $thread_id);
mysqli_close($link);
?>

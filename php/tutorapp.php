<?php
$tut_gtid = $_SESSION['myusername'];
$name = $_POST['name'];
$email = $_POST['email'];
$gpa = $_POST['gpa'];
$phone = $_POST['phone'];

$daytime = array();
$class = array();
// Get the day times and the classes

if(checkForUpdatedInfo($tut_gtid, $name, $email, $gpa, $phone)){
	//Update info
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
	$query = "UPDATE User SET Name = '$name', Email = '$email', GPA = '$gpa', Phone = '$phone' WHERE GT_ID = '$tut_gtid'";
	$result = mysqli_query($con, $query);
	mysqli_close($con);
}

//insert classes and availabilities


function checkForUpdatedInfo($gtid, $n, $e, $g, $p){
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
	$query = "SELECT Name, Email, GPA, Phone FROM User WHERE GT_ID = '$gtid'";
	$result = mysqli_query($con, $query);
	
	$row = mysqli_fetch_row($result);
	$name_db = $row[0];
	$email_db = $row[1];
	$gpa_db = $row[2];
	$phone_db = $row[3];
	
	mysqli_close($con);
	
	return $name_db == $n && $email_db == $e && $gpa_db == $g && $phone_db == $p;
}

?>
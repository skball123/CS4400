<?php
session_start();
$tut_gtid = $_SESSION['myusername'];

$json = array();
$json['check'][] = 'pass';
$json['gtid'] = $tut_gtid;
$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	
	$TutSched = "SELECT Hires.DayTimeSlotHired, User.Name, User.Email, Hires.SchoolName, Hires.CrNumber FROM Hires INNER JOIN User ON Hires.UnGT_ID = User.GT_ID WHERE Hires.TutordGT_ID ='$tut_gtid'";
	$result = mysqli_query($con, $TutSched);
	while( $row = mysqli_fetch_row($result) ) {
		$json['slothired'][] = $row[0];
		$json['name'][] = $row[1];
		$json['email'][] = $row[2];
		$json['school'][] = $row[3];
		$json['crn'][] = $row[4];
	}
	
echo json_encode($json);	

?>
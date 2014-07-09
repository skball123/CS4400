<?php

$course = $_POST['course'];

$school = strtok($course, " ");
$number = strtok(" ");
$json = array();
$temp3 = array();
$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	
$query = "SELECT TutorsGT_ID, GTA FROM TutorsCourse WHERE SName = '$school' AND CNum = '$number'";
$result = mysqli_query($con, $query);

while($row = mysqli_fetch_row($result)) {
	$temp3 = CheckTimes($con, $row[0]);
	$query3 = "SELECT TName FROM Tutor WHERE TGT_ID = '$row[0]'";
	$result3 = mysqli_query($con, $query3);	
	$row[0] = mysqli_fetch_row($result3);  //replaces GTID of retrieved tutor with their name 
	if( $row[1] ) { $row[1] = 'Yes'; } else { $row[1] = 'No'; }
	
	
	$json['tutor'][] = $row;
	$json['times'][] = $temp3;
}

function CheckTimes($con, $tutorgtid) {
$query2 = "SELECT DayTime FROM TutorTimeSlots WHERE TutorGT_ID = '$tutorgtid' ORDER BY DayTime ASC";  //which mean we get Fridays, Mondays, Thursdays, Tuesdays, Wednesdays
$result2 = mysqli_query($con, $query2);
$temp2 = array();
	while($row2 = mysqli_fetch_row($result2) ) {
		$day = substr($row2[0], 0, 1); //gets out first letter for day
		$time = substr($row2[0], 1, 3); //gets out 24hr time
		$time = $time . ':00';
		
		$temp2[] = "$day $time";
		
		
		
	}
	return $temp2;	
}


	

header('Content-Type: application/json');
echo json_encode($json);


?>



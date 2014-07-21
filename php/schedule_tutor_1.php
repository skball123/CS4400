<?php
session_start();
$tut_gtid = strtok($_POST['tutgtid'], " ");
$stu_gtid = $_SESSION['myusername'];
$semester = "Summer";
$daytime = array();
$length = $_POST['numTimes'];

for($i = 0; $i < ($length + 1); $i++) {
	if ( ($_POST['time' . $i]) < 10) { $time =  '0' . $_POST['time' . $i]; } else { $time  = $_POST['time' . $i]; }
	$daytime[] = $_POST['day' . $i] . $time;  //variable in example 'W15' format for wednesday 3pm 
}



$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
	$query = "SELECT DayTime FROM TutorTimeSlots WHERE TutorGT_ID = '$tut_gtid' AND Taken = '0' AND Semester = '$semester' AND (";
	$arraysize = count($daytime);  //gets length of array
	for( $i = 0; $i < $arraysize; $i++) {
		$temp = "DayTime = '$daytime[$i]' OR ";
		$query = $query . $temp;
	}
	$query = substr($query, 0, -4);
	$query = $query . ')';
	$json['query-tutor'][] = $query;
	$result = mysqli_query($con, $query);
	
	while( $row = mysqli_fetch_row($result) ) {
			$json['daytime'][] =  $row[0];		
	}
	
	header('Content-Type: application/json');
	echo json_encode($json);
	mysqli_close($con);

?>
<?php
session_start();
$tut_gtid = strtok($_POST['tutgtid'], " ");
$coursenum = $_POST['courseName'];
$stu_gtid = $_SESSION['myusername'];
$selected_time = $_POST['selectedTime'];
$json['vars'][] = $_POST['tutgtid'];
$json['vars'][] = $coursenum;
$json['vars'][] = $stu_gtid;
$json['vars'][] = $selected_time;

$semester = "Summer";

$school = strtok($coursenum, " ");
$coursenum = strtok(" ");

if(checkIfAlreadyScheduled($stu_gtid, $coursenum, $school)){
	$json['success'][] = 0;
	$json['message'][] = "You can only register for a single tutoring session for each individual course.";
	header('Content-Type: application/json');
	echo json_encode($json);
}else{
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
	$query = "INSERT INTO Hires VALUES ('$stu_gtid', '$tut_gtid', '$semester', '$selected_time', '$coursenum', '$school')";
	$result = mysqli_query($con, $query);
	
	//mark the timeslot as taken
	$query = "UPDATE TutorTimeSlots SET Taken = '1' WHERE TutorGT_ID = '$tut_gtid' AND Semester = '$semester' AND DayTime = '$selected_time'";
	$result = mysqli_query($con, $query);
	mysqli_close($con);
	
	$json['success'][] = 1;
	header('Content-Type: application/json');
	echo json_encode($json);
}

	
function checkIfAlreadyScheduled($stu_gtid, $coursenum, $school){
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
	$query = "SELECT UnGT_ID FROM Hires WHERE UnGT_ID = '$stu_gtid' AND CrNumber = '$coursenum' AND SchoolName = '$school' AND SemesterSlotHired = '$semester'";
	$result = mysqli_query($con, $query);
	mysqli_close($con);
	if(mysqli_num_rows($result) > 0){
		return 1;
	}else{
		return 0;
	}
}
?>
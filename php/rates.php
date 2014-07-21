<?php
session_start();
$num_eval = $_POST['num_eval'];
$desc_eval = $_POST['desc_eval'];
$coursenum = $_POST['courseName'];
$school = strtok($coursenum, " ");
$coursenum = strtok(" ");


$semester = 'Summer';

$tut_gtid = strtok($_POST['tutgtid'], " ");
$stu_gtid = $_SESSION['myusername'];

//json postvars
$json['postVar'][] = $num_eval;
$json['postVar'][] = $desc_eval;
$json['postVar'][] = $school;
$json['postVar'][] = $coursenum;
$json['postVar'][] = $tut_gtid;
$json['postVar'][] = $stu_gtid;
$json['postVar'][] = $_POST['tutgtid'];
$json['postVar'][] = $_POST['courseName'];


$checker = Checkteach($tut_gtid, $stu_gtid, $coursenum, $school, $semester, $json);  //check if student is being taught by tutor in course
if($checker) {
	$bool = Checkalready($tut_gtid, $stu_gtid, $coursenum, $school, $semester, $json);  // check if student already rated tutor
	StuEval($bool, $desc_eval, $num_eval, $tut_gtid, $stu_gtid, $coursenum, $school, $semester, $json);
}
	header('Content-Type: application/json');
	echo json_encode($json);

function Checkteach($tut_gtid, $stu_gtid, $coursenum, $school, $semester, &$json) {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$query = "SELECT TutordGT_ID FROM Hires WHERE Hires.UnGT_ID = '$stu_gtid' AND TutordGT_ID = '$tut_gtid' AND CrNumber = '$coursenum' AND SchoolName = '$school' AND SemesterSlotHired = '$semester'";
	//
	$result = mysqli_query($con, $query);	
	$count = mysqli_num_rows($result);
	if($count > 0) { return 1; }
	else {
	 $json['message'][] ='You cannot rate this tutor without having a session with them.';
	 $json['success'][] = 0;
	 return 0; }
	mysqli_close($con);
}

function Checkalready($tut_gtid, $stu_gtid, $coursenum, $school, $semester, &$json) {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$query = "SELECT TutoGT_ID FROM Rates WHERE UndGT_ID = '$stu_gtid' AND TutoGT_ID = '$tut_gtid' AND RSemester = '$semester' AND SchName = '$school' AND CouNumber = '$coursenum'";
	//echo($query);
	$result = mysqli_query($con, $query);	
	$count = mysqli_num_rows($result);
	if($count>0) { return 1; }
	else { return 0; }
	mysqli_close($con);
}

function StuEval($bool, $desc_eval, $num_eval, $tut_gtid, $stu_gtid, $coursenum, $school, $semester, &$json) {	//takes in bool for choice of update or insert record
	$desc_eval = str_replace("'","''",$desc_eval);
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	if($bool) {	
		$json['message'][] = 'You have already rated this tutor. This new rating will overwrite the old one.';
		$query = "UPDATE Rates SET STDesc_Eval = '$desc_eval', STNum_Eval = '$num_eval', RSemester = '$semester', SchName = '$school', CouNumber = '$coursenum' WHERE TutoGT_ID = '$tut_gtid' AND UndGT_ID = '$stu_gtid'";
		$result = mysqli_query($con, $query);	
	}
	else {
		$query = "INSERT INTO Rates VALUES ('$tut_gtid', '$stu_gtid', '$desc_eval', '$num_eval', '$semester', '$school', '$coursenum')";
		//echo($query);
		$result = mysqli_query($con, $query);
		$json['message'][] = 'Evaluation Submitted.';
	
	}
	mysqli_close($con);
	$json['success'][] = 1;
}
?>
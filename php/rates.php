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

$checker = Checkteach($tut_gtid, $stu_gtid, $coursenum, $school, $semester);  //check if student is being taught by tutor in course
if($checker) {
	$bool = Checkalready($tut_gtid, $stu_gtid, $coursenum, $school);  // check if student already rated tutor
	StuEval($bool, $desc_eval, $num_eval, $tut_gtid, $stu_gtid, $coursenum, $school, $semester);
}	
else {
echo('no session');
}


function Checkteach($tut_gtid, $stu_gtid, $coursenum, $school, $semester) {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$query = "SELECT TutordGT_ID FROM Hires WHERE Hires.UnGT_ID = '$stu_gtid' AND TutordGT_ID = '$tut_gtid' AND CrNumber = '$coursenum' AND SchoolName = '$school' AND SemesterSlotHired = '$semester'";
	echo($query);
	$result = mysqli_query($con, $query);	
	$count = mysqli_num_rows($result);
	if($count > 0) { return 1; }
	else {
	 echo('<script>alert("You cannot rate this tutor without having a session with them."); window.location = "http://samkirsch.net/cs4400/student-menu.php"</script>');
	 return 0; }
	mysqli_close($con);
}

function Checkalready($tut_gtid, $stu_gtid, $coursenum, $school) {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$query = "SELECT TutoGT_ID FROM Rates WHERE UndGT_ID = '$stu_gtid' AND TutoGT_ID = '$tut_gtid' AND RSemester = '$semester' AND SchName = '$school' AND CouNumber = '$coursenum'";
	$result = mysqli_query($con, $query);	
	$count = mysqli_num_rows($result);
	if($count) { return 1; }
	else { return 0; }
	mysqli_close($con);
}

function StuEval($bool, $desc_eval, $num_eval, $tut_gtid, $stu_gtid, $coursenum, $school, $semester) {	//takes in bool for choice of update or insert record
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	if($bool) {	
	echo('<script>alert("You have already rated this tutor. This new rating will overwrite the old one."); window.location = "http://samkirsch.net/cs4400/student-menu.php"</script>');
	$query = "UPDATE Rates SET STDesc_Eval = '$desc_eval', STNum_Eval = '$num_eval', RSemester = '$semester', SchName = '$school', CouNumber = '$coursenum' WHERE TutoGT_ID = '$tut_gtid' AND UndGT_ID = '$stu_gtid'";
	$result = mysqli_query($con, $query);	
	}
	else {
	$query = "INSERT INTO Rates VALUES ('$tut_gtid', '$stu_gtid', '$desc_eval', $num_eval', '$semester', $school', '$coursenum')";
	$result = mysqli_query($con, $query);
	echo('<script>alert("Evaluation Submitted."); window.location = "http://samkirsch.net/cs4400/student-menu.php"</script>');
	
	}
	mysqli_close($con);
}


?>
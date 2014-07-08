<?php
session_start();
$num_eval = $_POST['num_eval'];
$desc_eval = $_POST['desc_eval'];
$tut_gtid = $_POST['tutgtid'];
$profgtid = $_SESSION['myusername'];

$tut_gtid = strtok($tut_gtid, " "); // removes name that was at the end 

$valid = CheckValid($tut_gtid);

if($valid) {
	$bool = CheckProfEval($tut_gtid, $profgtid);
	ProfEval($bool, $desc_eval, $num_eval, $tut_gtid, $profgtid);
}
else {
	echo('<script>alert("This GTID does not exist in the Tutor database, please check it and try again"); window.location = "http://samkirsch.net/cs4400/professor-menu.php"</script>');
	}	

function CheckValid($tut_gtid) {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$query = "SELECT * FROM Tutor WHERE TGT_ID ='$tut_gtid'";
	$result = mysqli_query($con, $query);
	$count = mysqli_num_rows($result);
	if($count) { return 1; }
	else { return 0; }
	mysqli_close($con);	

}

function CheckProfEval($tut_gtid, $profgtid) {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$query = "SELECT TutGT_ID FROM Recommends WHERE ProfGT_ID ='$profgtid' AND TutGT_ID ='$tut_gtid'";
	$result = mysqli_query($con, $query);	
	$count = mysqli_num_rows($result);
	if($count) { return 1; }
	else { return 0; }
	mysqli_close($con);
}

function ProfEval($bool, $desc_eval, $num_eval, $tut_gtid, $profgtid) {	//takes in bool for choice of update or insert record
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	if($bool) {	
	echo('<script>alert("There is already an evaluation for this Tutor. This will overwrite the previous evaluation."); window.location = "http://samkirsch.net/cs4400/professor-menu.php"</script>');
	$query = "UPDATE Recommends SET Desc_Evaluation = '$desc_eval', Num_Evaluation = '$num_eval' WHERE TutGT_ID = '$tut_gtid' AND ProfGT_ID = '$profgtid'";
	$result = mysqli_query($con, $query);	
	mysqli_close($con);
	}
	else {
	$query = "INSERT INTO Recommends VALUES ('$tut_gtid', '$profgtid', '$desc_eval', '$num_eval')";
	$result = mysqli_query($con, $query);
	echo('<script>alert("Recommendation Submitted!"); window.location = "http://samkirsch.net/cs4400/professor-menu.php"</script>');
	mysqli_close($con);
	}
}

?>
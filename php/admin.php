<?php

$report = $_POST['button'];  //0 for avg ratings , 1 for course numbers
$fall = $_POST['checkbox1'];  //Bool
$spring = $_POST['checkbox2'];  //bool
$summer = $_POST['checkbox3'];  //bool
$json = array();

if($report) {
	// course number function
	
}
else {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	
	if($fall == 'true') {	
		$grad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutoGT_ID = TutorsGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Fall' AND GTA = 1";
		$result = mysqli_query($con, $grad_table);
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				$json['gradfall'][] = $row;
			}
		}
		mysqli_free_result($result);
		$undgrad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Fall' AND GTA = 0";
		$result = mysqli_query($con, $undgrad_table);
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				$json['undgradfall'][] = $row;
			}
		}
		mysqli_free_result($result);
	}
	
	if($spring  == 'true') {	
		$grad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Spring' AND GTA = 1";
		$result = mysqli_query($con, $grad_table);	
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				$json['gradspring'][] = $row;
			}
		}
		mysqli_free_result($result);
		$undgrad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Spring' AND GTA = 0";
		$result = mysqli_query($con, $undgrad_table);
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				$json['undgradspring'][] = $row;
			}
		}
		mysqli_free_result($result);
	}
	
	if($summer  == 'true') {	
		$grad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Summer' AND GTA = 1";
		$result = mysqli_query($con, $grad_table);	
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				$json['gradsummer'][] = $row;
			}
		}
		mysqli_free_result($result);
		$undgrad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Summer' AND GTA = 0";
		$result = mysqli_query($con, $undgrad_table);
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				$json['undgradsummer'][] = $row;
			}
		}
		mysqli_free_result($result);
	}
	
	
	mysqli_close($con);
	
}

echo json_encode($json);

?>
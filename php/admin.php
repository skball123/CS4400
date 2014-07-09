<?php

$report = $_POST['button'];  //1 for avg ratings , 0 for course numbers
$fall = $_POST['checkbox1'];  //Bool
$spring = $_POST['checkbox2'];  //bool
$summer = $_POST['checkbox3'];  //bool
$json = array();

if($report) {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	
	if($fall) {	
		$grad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutoGT_ID = TutorsGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Fall' AND GTA = 1";
		$result = mysqli_query($con, $grad_table);	
		while($row = mysqli_fetch_row($result)) {
			$json['grad-fall'][] = $row;
		}
		free($result);
		$undgrad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Fall' AND GTA = 0";
		$result = mysqli_query($con, $undgrad_table);
		while($row = mysqli_fetch_row($result)) {
			$json['undgrad-fall'][] = $row;
		}
		free($result);
	}
	
	if($spring) {	
		$grad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Spring' AND GTA = 1";
		$result = mysqli_query($con, $grad_table);	
		while($row = mysqli_fetch_row($result)) {
			$json['grad-spring'][] = $row;
		}
		free($result);
		$undgrad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Spring' AND GTA = 0";
		$result = mysqli_query($con, $undgrad_table);
		while($row = mysqli_fetch_row($result)) {
			$json['undgrad-spring'][] = $row;
		}
		free($result);
	}
	
	if($summer) {	
		$grad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Summer' AND GTA = 1";
		$result = mysqli_query($con, $grad_table);	
		while($row = mysqli_fetch_row($result)) {
			$json['grad-summer'][] = $row;
		}
		free($result);
		$undgrad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Summer' AND GTA = 0";
		$result = mysqli_query($con, $undgrad_table);
		while($row = mysqli_fetch_row($result)) {
			$json['undgrad-summer'][] = $row;
		}
		free($result);
	}
	
	
	mysqli_close($con);
	
}
else {

}

echo json_encode($json);

?>
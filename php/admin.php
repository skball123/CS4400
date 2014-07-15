<?php

$report = $_POST['button'];  //0 for avg ratings , 1 for course numbers
$fall = $_POST['checkbox1'];  //Bool
$spring = $_POST['checkbox2'];  //bool
$summer = $_POST['checkbox3'];  //bool
$tut_gtid = strtok($_POST['GTID'], " "); // removes name that was at the end 
$json = array();

if($report == 'numbers') {
	$json['type'] = 'numbers';
	
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	
	if($fall == 'true') {
		$count_fall = "SELECT SchoolName, CRNumber, COUNT(UnGT_ID), COUNT(TutordGT_ID) FROM Hires WHERE SemesterSlotHired = 'Fall' ORDER BY SchoolName, CrNumber";
		$result = mysqli_query($con, $count_fall);
		while( $row = mysqli_fetch_row($result) ) {
			if( !( is_null($row[0]) ) ) {
				$json['fallnumbers'][] = $row;
			}
		}	
	}
	
	if($spring == 'true') {
		$count_spring = "SELECT SchoolName, CRNumber, COUNT(UnGT_ID), COUNT(TutordGT_ID) FROM Hires WHERE SemesterSlotHired = 'Spring' ORDER BY SchoolName, CrNumber";
		$result = mysqli_query($con, $count_spring);
		while( $row = mysqli_fetch_row($result) ) {
			if( !( is_null($row[0]) ) ) {
				$json['springnumbers'][] = $row;
			}
		}	
	}
	
	if($summer == 'true') {
		$count_summer = "SELECT SchoolName, CRNumber, COUNT(UnGT_ID), COUNT(TutordGT_ID) FROM Hires WHERE SemesterSlotHired = 'Summer' ORDER BY SchoolName, CrNumber";
		$result = mysqli_query($con, $count_summer);
		while( $row = mysqli_fetch_row($result) ) {
			if( !( is_null($row[0]) ) ) {
				$json['summernumbers'][] = $row;
			}
		}	
	}
}
elseif($report == 'ratings') {
	$json['type'] = 'rating';
	
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	
	if($fall == 'true') {	
		$grad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutoGT_ID = TutorsGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Fall' AND GTA = 1 ORDER BY SName";
		$result = mysqli_query($con, $grad_table);
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				if( !($row[2] == 0) ) {
					$json['gradfall'][] = $row;
				}
			}
		}
		mysqli_free_result($result);
		$undgrad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Fall' AND GTA = 0 ORDER BY SName";
		$result = mysqli_query($con, $undgrad_table);
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				if( !($row[2] == 0) ) {
					$json['undgradfall'][] = $row;
				}
			}
		}
		mysqli_free_result($result);
	}
	
	if($spring  == 'true') {	
		$grad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Spring' AND GTA = 1 ORDER BY SName";
		$result = mysqli_query($con, $grad_table);	
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				if( !($row[2] == 0) ) {
					$json['gradspring'][] = $row;
				}
			}
		}
		mysqli_free_result($result);
		$undgrad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Spring' AND GTA = 0 ORDER BY SName";
		$result = mysqli_query($con, $undgrad_table);
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				if( !($row[2] == 0) ) {
					$json['undgradspring'][] = $row;
				}
			}
		}
		mysqli_free_result($result);
	}
	
	if($summer  == 'true') {	
		$grad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Summer' AND GTA = 1 ORDER BY SName";
		$result = mysqli_query($con, $grad_table);	
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				if( !($row[2] == 0) ) {
					$json['gradsummer'][] = $row;
				}
			}
		}
		mysqli_free_result($result);
		$undgrad_table = "SELECT SName, CNum, COUNT(TutorsGT_ID), AVG(STNum_Eval) FROM TutorsCourse INNER JOIN Rates ON TutorsGT_ID = TutoGT_ID AND SchName = SName AND CouNumber = CNum WHERE RSemester = 'Summer' AND GTA = 0 ORDER BY SName";
		$result = mysqli_query($con, $undgrad_table);
		$count=mysqli_num_rows($result);
		if($count > 0) {	
			while($row = mysqli_fetch_row($result)) {
				if( !($row[2] == 0) ) {
					$json['undgradsummer'][] = $row;
				}
			}
		}
		mysqli_free_result($result);
	}
	
}
elseif( $report == 'tutor' ) {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$TutSched = "SELECT Hires.DayTimeSlotHired, User.Name, User.Email, Hires.SchoolName, Hires.CrNumber FROM Hires INNER JOIN User ON Hires.UnGT_ID = User.GT_ID WHERE Hires.TutordGT_ID =$tut_gtid'";
	$result = mysqli_query($con, $tut_gtid);
	while( $row = mysqli_fetch_row($result) ) {
		$json['slothired'][] = $row[0];
		$json['name'][] = $row[1];
		$json['email'][] = $row[2];
		$json['school'][] = $row[3];
		$json['crn'][] = $row[4];
	}
	
}

mysqli_close($con);
echo json_encode($json);

?>
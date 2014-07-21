<?php
$semester = "Summer";
$tut_gtid = $_SESSION['myusername'];
$name = $_POST['name'];
$email = $_POST['email'];
$gpa = $_POST['gpa'];
$phone = $_POST['phone'];

$numClasses = $_POST['numClasses'];
$daytime = array();

$json['postVars'][] = $name;
$json['postVars'][] = $email;
$json['postVars'][] = $gpa;
$json['postVars'][] = $phone;

// Insert all of the tutors available classes
$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$bool = checkForUpdatedInfo($tut_gtid, $name, $email, $gpa, $phone);
$json['bool'][] = $bool;
if(!$bool){
	//Update info
	$query = "UPDATE User SET Name = '$name', Email = '$email', Phone = '$phone' WHERE GT_ID = '$tut_gtid'";
	$result = mysqli_query($con, $query);
	$query = "UPDATE Tutor SET GPA = $gpa WHERE TGT_ID = '$tut_gtid'";
	$result = mysqli_query($con, $query);
}
//First remove the previously listed courses
$query = "DELETE FROM TutorsCourse WHERE TutorsGT_ID = '$tut_gtid'";
$result = mysqli_query($con, $query);

// Now add all the courses this tutor listed that they can teach
for($i = 0; $i < $numClasses; $i++){
	$school = strtok($_POST['course' . $i], " ");
	$courseNum = strtok(" ");
	if(is_null($_POST['gta' . $i])){
		$gta = 0;
	}else{
		$gta = 1;
	}
	
	$course = $courseNum . $school;
	$query = "INSERT INTO TutorsCourse VALUES ('$tut_gtid', '$gta', '$name', '$course')";
	$result = mysqli_query($con, $query);
}

//Remove the previously listed timeslots
$query = "DELETE FROM TutorTimeSlots WHERE TutorGT_ID = '$tut_gtid'";
$result = mysqli_query($con, $query);

// Get the dayTimes by checking if the check box exists through all the possible times then insert
for($i = 7; $i <= 22; $i++){
	for($j = 0; $j < 5; $j++){
		switch($j){
			case 0: $day = 'M'; break;
			case 1: $day = 'T'; break;
			case 2: $day = 'W'; break;
			case 3: $day = 'R'; break;
			case 4: $day = 'F'; break;
		}
		if($i < 10){
			if(isset($_POST['$day . "0" . $i'])){
				$daytime[] = $day . "0" . $i;
			}
		}else{
			if(isset($_POST['$day . $i'])){
				$daytime[] = $day . $i;
			}
		}
		$query = "INSERT INTO TutorTimeSlots VALUES ('$tut_gtid', '$email', '$semester', '0', '$daytime')";
		$result = mysqli_query($con, $query);
	}
}

//close the connection
mysqli_close($con);

$json['success'][] = 1;
header('Content-Type: application/json');
echo json_encode($json);

function checkForUpdatedInfo($gtid, $n, $e, $g, $p){
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
	$query = "SELECT User.Name, User.Email, Tutor.GPA, User.Phone FROM User, Tutor WHERE TGT_ID = '$gtid' AND TGT_ID = GT_ID";
	$result = mysqli_query($con, $query);
	
	$row = mysqli_fetch_row($result);
	$name_db = $row[0];
	$email_db = $row[1];
	$gpa_db = $row[2];
	$phone_db = $row[3];
	
	mysqli_close($con);
	
	$json['dbVars'] = $name_db;
	$json['dbVars'] = $email_db;
	$json['dbVars'] = $gpa_db;
	$json['dbVars'] = $phone_db;
	
	return $name_db == $n && $email_db == $e && $gpa_db == $g && $phone_db == $p;
}

?>
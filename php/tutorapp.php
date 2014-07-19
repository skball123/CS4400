<?php
$tut_gtid = $_SESSION['myusername'];
$name = $_POST['name'];
$email = $_POST['email'];
$gpa = $_POST['gpa'];
$phone = $_POST['phone'];

$numClasses = $_POST['numClasses'];
$daytime = array();

//parrallel arrays storing the courseNums and schools i.e.  courseNums[0], schools[0] go together
$courseNums = array();
$schools = array();
$gta = array();

// Get the the classes
for($i = 0; $i < $numClasses; $i++){
	$schools[] = strtok($_POST['course' . $i], " ");
	$courseNums[] = strtok(" ");
	if(is_null($_POST['gta' . $i])){
		$gta[] = 0;
	}else{
		$gta[] = 1;
	}
}

// Get the dayTimes by checking if the checkbox exists through all the possible times
for($i = 7; $i <= 22; $i++){
	for($j = 0; $j < 7; $j++){
		switch($j){
			case 0: $day = 'M'; break;
			case 1: $day = 'T'; break;
			case 2: $day = 'W'; break;
			case 3: $day = 'R'; break;
			case 4: $day = 'F'; break;
			case 5: $day = 'S'; break;
			case 6: $day = 'Z'; break;
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
	}
}


if(checkForUpdatedInfo($tut_gtid, $name, $email, $gpa, $phone)){
	//Update info
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
	$query = "UPDATE User SET Name = '$name', Email = '$email', GPA = '$gpa', Phone = '$phone' WHERE GT_ID = '$tut_gtid'";
	$result = mysqli_query($con, $query);
	mysqli_close($con);
}

//insert classes and availabilities


function checkForUpdatedInfo($gtid, $n, $e, $g, $p){
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
	$query = "SELECT Name, Email, GPA, Phone FROM User WHERE GT_ID = '$gtid'";
	$result = mysqli_query($con, $query);
	
	$row = mysqli_fetch_row($result);
	$name_db = $row[0];
	$email_db = $row[1];
	$gpa_db = $row[2];
	$phone_db = $row[3];
	
	mysqli_close($con);
	
	return $name_db == $n && $email_db == $e && $gpa_db == $g && $phone_db == $p;
}

?>
<?php
$json = array();


$course = $_POST['course'];

$daytime = array();
$length = $_POST['numTimes'];

for($i = 0; $i < ($length + 1); $i++) {
	if ( ($_POST['time' . $i]) < 10) { $time =  '0' . $_POST['time' . $i]; } else { $time  = $_POST['time' . $i]; }
	$daytime[] = $_POST['day' . $i] . $time;  //variable in example 'W15' format for wednesday 3pm 
}

$school = strtok($course, " ");
$number = strtok(" ");

$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

/*
Get all Tutor GTID's that are avail during submitted times
*/		
$query2 = "SELECT TutorGT_ID FROM TutorTimeSlots WHERE Semester = 'Summer' AND Taken = '0' AND (";
$arraysize = count($daytime);  //gets length of array
for( $i = 0; $i < $arraysize; $i++) {
	$temp = "DayTime = '$daytime[$i]' OR ";
	$query2 = $query2 . $temp;
}

$query2 = substr($query2, 0, -4);
$query2 = $query2 . ')';
$json['query'] = $query2;
$result2 = mysqli_query($con, $query2);
$tutorsavail = array();
while($row2 = mysqli_fetch_row($result2) ) {
	$tutorsavail[] = $row2[0];
	$json['tutoravail'][] = $row2[0];
	$json['taken'][] = $row2[1];	
}			
	
$query = "SELECT TutorsGT_ID, GTA FROM TutorsCourse WHERE SName = '$school' AND CNum = '$number'";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_row($result)) {

	if( in_array($row[0], $tutorsavail) ) {		//if the tutor is avail during submitted times...
		$query3 = "SELECT Name,Email FROM User WHERE GT_ID = '$row[0]'";
		$result3 = mysqli_query($con, $query3);	
		$gtid = $row[0];
		$row2 = mysqli_fetch_row($result3);   
		$row[0] = $row2[0];			//replaces GTID of retrieved tutor with their name
		$email = $row2[1];
		if( $row[1] ) { $row[1] = 'Yes'; } else { $row[1] = 'No'; }
		
		$query4 = "SELECT COUNT(STNum_Eval), AVG(STNum_Eval) FROM Rates WHERE TutoGT_ID = '$gtid'";
		$result4 = mysqli_query($con, $query4);
		$query5 = "SELECT COUNT(Num_Evaluation), AVG(Num_Evaluation) FROM Recommends WHERE TutGT_ID = '$gtid'";
		$result5 = mysqli_query($con, $query5);
		
		$row3 = mysqli_fetch_row($result4);
		$row4 = mysqli_fetch_row($result5);
		if( $row4[0] == 0 ) {}
		else {
			$json['email'][] =  $email;
			$json['STnum'][] = $row3[0];
			$json['STavg'][] = $row3[1];
			$json['Pnum'][] = $row4[0];
			$json['Pavg'][] = $row4[1];
			$json['gtid'][] = $gtid;
			$json['tutor'][] = $row[0];
			$json['gta'][] = $row[1];
		}
	}
}



header('Content-Type: application/json');
echo json_encode($json);
?>



<?php
$json = array();


$course = $_POST['course'];

$daytime = array();
$length = $_POST['numTimes'];

for($i = 0; $i < ($length + 1); $i++) {
	$daytime[] = $_POST['day' . $i] . $_POST['time' . $i];  //variable in example 'W15' format for wednesday 3pm 
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
$query2 = "SELECT DISTINCT TutorGT_ID FROM TutorTimeSlots WHERE ";
$arraysize = count($daytime);  //gets length of array
for( $i = 0; $i < $arraysize; $i++) {
	$temp = "DayTime = '$daytime[$i]' OR ";
	$query2 = $query2 . $temp;
}

$query2 = substr($query2, 0, -4);
$result2 = mysqli_query($con, $query2);
$tutorsavail = array();
while($row2 = mysqli_fetch_row($result2) ) {
	$tutorsavail[] = $row2;	
}		
$json['avail'] = $tutorsavail;		
	
$query = "SELECT TutorsGT_ID, GTA FROM TutorsCourse WHERE SName = '$school' AND CNum = '$number'";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_row($result)) {
	if( in_array($row[0], $tutorsavail) ) {		//if the tutor is avail during submitted times...
		$query3 = "SELECT TName FROM Tutor WHERE TGT_ID = '$row[0]'";
		$result3 = mysqli_query($con, $query3);	
		$row[0] = mysqli_fetch_row($result3);  //replaces GTID of retrieved tutor with their name 
		if( $row[1] ) { $row[1] = 'Yes'; } else { $row[1] = 'No'; }
		
		$json['tutor'][] = $row;
	}
}



header('Content-Type: application/json');
echo json_encode($json);
?>



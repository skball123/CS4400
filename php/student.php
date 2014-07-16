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
	$tutorsavail[] = $row2[0];	
}			
	
$query = "SELECT TutorsGT_ID, GTA FROM TutorsCourse WHERE SName = '$school' AND CNum = '$number'";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_row($result)) {

	if( in_array($row[0], $tutorsavail) ) {		//if the tutor is avail during submitted times...
		$query3 = "SELECT Name FROM User WHERE GT_ID = '$row[0]'";
		$result3 = mysqli_query($con, $query3);	
		$gtid = $row[0];
		$row[0] = mysqli_fetch_row($result3);  //replaces GTID of retrieved tutor with their name 
		if( $row[1] ) { $row[1] = 'Yes'; } else { $row[1] = 'No'; }
		
		$query4 = "SELECT Email, COUNT(STNum_Eval), AVG(STNum_Eval), COUNT(Num_Evaluation), AVG(Num_Evaluation) FROM (User INNER JOIN Rates ON GT_ID = TutoGT_ID) INNER JOIN Recommends ON GT_ID = TutGT_ID WHERE GT_ID = '$gtid'";
		$result4 = mysqli_query($con, $query4); 
		while( $row3 = mysqli_fetch_row($result4) ) {
			$json['email'][] =  $row3[0];
			$json['STnum'][] = $row3[1];
			$json['STavg'][] = $row3[2];
			$json['Pnum'][] = $row3[3];
			$json['Pavg'][] = $row3[4];
		
		}
		
		$json['gtid'][] = $gtid;
		$json['tutor'][] = $row[0];
		$json['gta'][] = $row[1];
	}
}



header('Content-Type: application/json');
echo json_encode($json);
?>



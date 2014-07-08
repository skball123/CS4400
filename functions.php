<?php

//        PHP FUNCTIONS  	    //
// FOR USE WITH CS4400 Project  //
//       GT Tutor System        //
//       GTL Summer 2014        //


function FetchClasses() {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$query = "SELECT School,Number FROM Course ORDER BY School, Number";
	$result = mysqli_query($con, $query);
	
	$school_num = '[';
	
	while($row = mysqli_fetch_row($result) ) {  
		$school = $row[0];
		$number = $row[1];
		
		$school_num = $school_num . "'" . $school . " " . $number . "',";
	
	}
	$school_num = substr_replace($school_num ,"]",-1);
	return $school_num;
	mysqli_close($con);
}

function FetchTutors() {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$query = "SELECT TGT_ID,TName FROM Tutor";
	$result = mysqli_query($con, $query);
	
	$tutor_list = '[';
	
	while($row = mysqli_fetch_row($result) ) {  
		$tutorgtid = $row[0];
		$tutorname = $row[1];
		
		$tutor_list = $tutor_list . "'" . $tutorgtid . " (" . $tutorname . ")',";
	
	}
	$tutor_list = substr_replace($tutor_list ,"]",-1);
	return $tutor_list;
	mysqli_close($con);
}
/*
function FetchTutorClasses($class) {
	$school = strtok($class, " ");
	$number = strtok(" ");
	$json = array();
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	
	$query = "SELECT TutorsGT_ID, GTA FROM TutorsCourse WHERE SName = '$school' AND CNum = '$number'";
	$result = mysqli_query($con, $query);
	
	$query2 = "SELECT DayTime, Semester, Taken FROM TutorTimeSlots WHERE TutorGT_ID = '$tutorgtid' ORDER BY DayTime ASC";  //which mean we get Fridays, Mondays, Thursdays, Tuesdays, Wednesdays
	$result2 = mysqli_query($con, $query);
	
	while($row = mysqli_fetch_row($result) && $row2 = mysqli_fetch_row($result2) ) { 
		$day = substr($row2[0], 0, 1); //gets out first letter for day
		$time = substr($row2[0], 2, 3); //gets out 24hr time
		$time = $time . ':00';
		
		switch ($day) {
			
			case 'M':
				$day = 'Monday';
			case 'T':
				$day = 'Tuesday';
			case 'W':
				$day = 'Wednesday';
			case 'R':
				$day = 'Thursday';
			case 'F':				
				$day = 'Friday';
		}
		
		cat[] = 
		
		$json[] = $row;
		
	}
	
}

function TimeSlotCheck($tutorgtid, $con) {
	
	
	while($row = mysqli_fetch_row($result) ) {
		$day = substr($row[0], 0, 1); //gets out first letter for day
		$time = substr($row[0], 2, 3); //gets out 24hr time
		$time = $time . ':00';
		
		switch $day {
			
			case 'M':
				$day = 'Monday';
			case 'T':
				$day = 'Tuesday';
			case 'W':
				$day = 'Wednesday';
			case 'R':
				$day = 'Thursday';
			case 'F':				
				$day = 'Friday';
		}
		
		
	
	}
}

*/

?>
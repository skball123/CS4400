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
	$query = "SELECT GT_ID,Name FROM User WHERE User_Type = 'TUT'";
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

?>
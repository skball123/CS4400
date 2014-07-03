<?php

//        PHP FUNCTIONS  	    //
// FOR USE WITH CS4400 Project  //
//       GT Tutor System        //
//       GTL Summer 2014        //

function connectdb() {
	$con = mysqli_connect("localhost","kirsch_cs4400","georgiatech","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	return $con;
}


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

function CheckProfEval($tut_gtid, $profgtid) {
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$query = "SELECT TutoGT_ID FROM Recommends WHERE ProfGT_ID ='$profgtid' AND TutoGT_ID ='$tut_gtid'";
	$count=mysqli_num_rows($result);
	if($count) { return true; }
	else { return false; }

}

function ProfEval($bool, $desc_eval, $num_eval, $tut_gtid, $profgtid) {	//takes in bool for choice of update or insert record
	$con = mysqli_connect("localhost","kirsch_cs4400","cs4400GT","kirsch_cs4400");
	// Check connection
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	if($bool) {	
	$query = "UPDATE Recommends SET Desc_Evaluation = '$desc_eval', Num_Evaluation = '$num_eval' WHERE TutoGT_ID = '$tut_gtid' AND ProfGT_ID = '$profgtid'";
	$result = mysqli_query($con, $query);	
	}
	else {
	$query = "INSET INTO Recommends VALUES ($profgtid, $tut_gtid, $desc_eval, $num_eval";
	$result = mysqli_query($con, $query);
	
	}
}







?>
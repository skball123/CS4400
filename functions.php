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
}

function closedb() {
	mysqli_close($con);
}

function fetchdata() {
	$query = "SELECT atribute,atribute FROM table ORDER BY artibute";
	$result = mysqli_query($con, $query);
	
	while($row = mysqli_fetch_array( $result, MYSQLI_NUM) ) {  // while there is another row...
	printf ( "%s, %s \n", $row[0], $row[1] );  // gets the 2 atributes from each row
	
	}
}






?>
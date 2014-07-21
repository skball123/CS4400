<?php

//=== Check if user is logged in ===
session_start();
if(!isset($_SESSION['myusername'])) //User is not logged in
{
  header("location:http://samkirsch.net/cs4400");
    die("You are not logged in");
}

if(!($_SESSION['type'] == 'ADM')) 
{
  $type = $_SESSION['type'];
	
	switch($type) {
		case "STU":
			header("location:http://samkirsch.net/cs4400/student-menu.php");
			break;
		case "TUT":
			header("location:http://samkirsch.net/cs4400/tutor-menu.php");
			break;
		case "PRO":
			header("location:http://samkirsch.net/cs4400/professor-menu.php");
			break;		
	}
}

include 'functions.php';

$states = FetchTutors();


echo("
<!DOCTYPE html>
<html>
<script> var states = " . $states . " </script>

");
?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GT Tutor System</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    
     <link href="css/professor-menu.css" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div id="wrap">
  	<a href="php/logout.php" class="logout">Logout</a>
     <div class="container">
     	<div class="content">
			 <h2 class="heading">Administrator Reports</h2>
			 <div class="open">
			 	<div class="checkbox">
		      			<input type="checkbox" name="semester" id="semester1" value="Fall">Fall
		      	</div>
		      	<div class="checkbox">
		      			<input type="checkbox" name="semester" id="semester2" value="Spri">Spring
		      	</div>
		      	<div class="checkbox">
		      			<input type="checkbox" name="semester" id="semester3" value="Sumr">Summer
		      	</div>
		      	<button class="btn btn-lg btn-primary btn-block" type="submit" id="button" name="button" value="numbers">Create Course Numbers Report</button>
		        <button class="btn btn-lg btn-primary btn-block" type="submit" id="button" name="button" value="ratings">Create Average Ratings Report</button>
		        <br />
		        <div id="dropdown">
		        	<input type="search" name="tutgtid" id="tutgtid" class="form-control typeahead" maxlength="9" placeholder="Tutor GTID or Name" required autofocus>
		        </div>
		        <button class="btn btn-lg btn-primary btn-block" type="submit" id="button" name="button" value="tutor">Lookup Tutor Schedule</button>    	    	
			</div>
			<div class="modal fade">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        					<h4 class="modal-title"></h4>
      					</div>
      					<div class="modal-body reports panel panel-default span12">
        					
      					</div>
   				 </div><!-- /.modal-content -->
  			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		</div> <!-- /content -->
    </div> <!-- /container -->
    </div>


    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
     <script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
     	<script src="js/admin-menu.js"></script>
  </body>
</html>
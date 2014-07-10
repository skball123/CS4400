<?php

//=== Check if user is logged in ===
session_start();
if(!isset($_SESSION['myusername'])) //User is not logged in
{
  header("location:http://samkirsch.net/cs4400");
    die("You are not logged in");
}

include 'functions.php';

$states = FetchClasses();

echo('
<!DOCTYPE html>
<html lang="en">
<script> var states = '. $states .' </script>

');
?>


  <head>	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GT Tutor System</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/student-menu.css" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
     <div class="container">
     	<div class="content">
     		<div class="row">
     			<div class="col-lg-6">
		     		<div class="input-group">
			     		<div id="dropdown">
			     			<input id="course_search" name="course" type="search" class="form-control typeahead" placeholder="Course Name" onkeydown="if (event.keyCode == 13) document.getElementById('search_btn').click()">
			     		</div>
			     		<span class="input-group-btn btn-2">
			     		<button id="search_btn" class="btn btn-primary " type="button">
								<span class="glyphicon glyphicon-search col-lg-4" style="vertical-align:middle"></span>
						</button>
						</span>
		     		</div>
	     		</div>
     		</div>
			<div class="btn-group-wrap">
				<div class="btn-container btn-group">
					<button type="button" class="btn btn-primary">Search for a Tutor</button>
				</div>
			</div>
		</div>
    </div> <!-- /container -->
    <div class="container-fluid">
		<div class="row">
			<div class="tutor-list panel panel-default span12" style="display: none; float: none; margin: 0 auto;">
			</div>
		</div>
    </div>
    
    <!-- Modal -->
	<div class="modal fade" id="student_hours_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Add Your Availability</h4>
	      </div>
	      <div class="modal-body">
	        <div class="input-group">
	        	<span class="input-group-btn">
	        		<button type="button" class="btn btn-default day_btn" name="day0">Mo</button>
	        	</span>
	        	<select class="form-control">
	        		<option value="7">7:00AM</option>
	        		<option value="8">8:00AM</option>
	        		<option value="9">9:00AM</option>
	        		<option value="10">10:00AM</option>
	        		<option value="11">11:00AM</option>
	        		<option value="12">12:00PM</option>
	        		<option value="13">1:00PM</option>
	        		<option value="14">2:00PM</option>
	        		<option value="15">3:00PM</option>
	        		<option value="16">4:00PM</option>
	        		<option value="17">5:00PM</option>
	        		<option value="18">6:00PM</option>
	        		<option value="19">7:00PM</option>
	        		<option value="20">8:00PM</option>
	        		<option value="21">9:00PM</option>
	        		<option value="22">10:00PM</option>
	        		<option value="23">11:00PM</option>
	        		<option value="0">8:00AM</option>
	        		<option value="1">9:00AM</option>
	        		<option value="2">10:00AM</option>
	        		<option value="3">7:00AM</option>
	        		<option value="4">8:00AM</option>
	        		<option value="5">9:00AM</option>
	        		<option value="6">10:00AM</option>
	        	</select>
	        	
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" id="student_hours_modal_btn" class="btn btn-primary">Submit</button>
	      </div>
	    </div>
	  </div>
	</div>


    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
 	<script src="js/student-menu.js"></script>
  </body>
</html>
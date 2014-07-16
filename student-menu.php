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
			     		<button id="search_btn" class="btn btn-primary search_btn" type="button">
								<span class="glyphicon glyphicon-search col-lg-4" style="vertical-align:middle"></span>
						</button>
						</span>
		     		</div>
	     		</div>
     		</div>
			<div class="btn-group-wrap">
				<div class="btn-container btn-group">
					<button type="button" class="btn btn-primary search_btn">Search for a Tutor</button>
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
    
    <!-- Time Availability Modal -->
	<div class="modal fade" id="student_hours_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Add Your Availability</h4>
	      </div>
	      <div class="modal-body" id="modal_form">
	        <div class="input-group time_input">
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
	        	</select>
	        	
	        </div>
	      </div>
	      <div class="modal-footer">
			<button type="button" id="add_time_btn" class="btn btn-default">Add Time</button>
	        <button type="button" id="student_hours_modal_btn" class="btn btn-primary">Submit</button>
	      </div>
	    </div>
	  </div>
	</div> <!-- End Time Availability Modal -->
	
	<!-- Tutor Rate Modal -->
	<div class="modal fade" id="rate_tutor_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Rate this Tutor</h4>
	      </div>
	      <div class="modal-body" id="modal_rate_form">
			<div class="row">
				<div class="span6">
					<div class="col-lg-3">
						<input type="text" name="tutgtid" id="tutgtid" class="form-control" maxlength="9" placeholder="Tutor GTID or Name" disabled="disabled">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span6">
					<div class="col-lg-3">
						<input type="text" name="courseName" id="rateCourseName" class="form-control" maxlength="9" placeholder="Course Name" disabled="disabled">
					</div>
				</div>
			</div>
			<h5>Descriptive Evaluation</h5>
			<textarea class="form-control" id="desc_eval" required rows="4" maxlength="300" name="desc_eval"></textarea>
			
			<div class="radio">
				<label>
					<input required type="radio" name="num_eval" id="radio_4" value="4">
					4 Highly Recommend
				</label>
			</div>
			<div class="radio">
				<label>
					<input required type="radio" name="num_eval" id="radio_3" value="3">
					3 Recommend
				</label>
			</div>
			<div class="radio">
				<label>
					<input required type="radio" name="num_eval" id="radio_2" value="2">
					2 Recommend with reservations
				</label>
			</div>
			<div class="radio">
				<label>
					<input required type="radio" name="num_eval" id="radio_1" value="1">
					1 Do Not Recommend
				</label>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" id="rate_tutor_modal_btn" class="btn btn-primary">Submit</button>
	      </div>
	    </div>
	  </div>
	</div>
	
	<!-- Tutor Schedule Modal -->
	<div class="modal fade" id="schedule_tutor_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Schedule a Tutoring Session</h4>
	      </div>
	      <div class="modal-body" id="modal_schedule_form">
		  <div class="row">
			<form id="schedule_form">
				<div id="sched_post_data">
					<div class="span6">
						<div class="col-lg-3">
							<input type="text" name="tutgtid" id="tutgtid_sched" class="form-control" maxlength="9" placeholder="Tutor GTID or Name" disabled="disabled">
						</div>
						<div class="col-lg-3">
							<input type="text" name="courseName" id="schedCourseName" class="form-control" maxlength="9" placeholder="Course Name" disabled="disabled">
						</div>
					</div>
				</div>
			</form>
			</div>
			<div id="sched_table_div" style="padding: 10px;">
			</div>
	      </div>
	    </div>
	  </div>
	</div>
	
	<!-- Rate Success Modal -->
	<div class="modal fade" id="rate_success_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Success!</h4>
	      </div>
	      <div class="modal-body" id="rate_success_modal_body">
			<p>Your rating has been submitted.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" id="rates_success_btn" class="btn btn-success">
				<span class="glyphicon glyphicon-ok"></span>
			</button>
	      </div>
	    </div>
	  </div>
	</div> <!-- End Rate Success Modal -->
	
	<!-- Confirm Scheduling Modal -->
	<div class="modal fade" id="confirm_sched_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header"></div>
	      <div class="modal-body" id="rate_success_modal_body">
			<h4 class="modal-title" id="myModalLabel">Confirm Scheduling</h4>
			<p>Are you sure you want to schedule this tutoring session?</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" id="s_confirm_yes" class="btn btn-success">
				<span class="glyphicon glyphicon-ok"></span>
			</button>
			<button type="button" id="s_confirm_no" class="btn btn-danger">
				<span class="glyphicon glyphicon-remove"></span>
			</button>
	      </div>
	    </div>
	  </div>
	</div> <!-- Confirm Scheduling Modal -->
	
	<!-- Schedule Success Modal -->
	<div class="modal fade" id="schedule_success_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Success!</h4>
	      </div>
	      <div class="modal-body" id="schedule_success_modal_body">
			<p>Your tutoring session has been scheduled.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" id="schedule_success_btn" class="btn btn-success" data-dismiss="modal">
				<span class="glyphicon glyphicon-ok"></span>
			</button>
	      </div>
	    </div>
	  </div>
	</div> <!-- End Schedule Success Modal -->
	
	<!-- Schedule Fail Modal -->
	<div class="modal fade" id="schedule_fail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Oops! Something went wrong.</h4>
	      </div>
	      <div class="modal-body" id="schedule_fail_modal_body">
			<p id="schedule_fail_message">Your tutoring session has been scheduled.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" id="schedule_fail_btn" class="btn btn-success" data-dismiss="modal">
				<span class="glyphicon glyphicon-ok"></span>
			</button>
	      </div>
	    </div>
	  </div>
	</div> <!-- End Schedule Fail Modal -->
	
	<div id="tutor_info" style="display: none;">
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
 	<script src="js/student-menu.js"></script>
  </body>
</html>
<?php

//=== Check if user is logged in ===
session_start();
if(!isset($_SESSION['myusername'])) //User is not logged in
{
  header("location:http://samkirsch.net/cs4400");
    die("You are not logged in");
}

include 'functions.php';
echo('<script>var user = "'.$_SESSION['myusername'].'"</script>');
?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GT Tutor System</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    
     <link href="css/tutor-menu.css" rel="stylesheet">
    
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
			  <h2 class="heading">Tutor Menu</h2>
		      <button class="btn btn-lg btn-primary btn-block" type="button" id="apply">Apply</button>
		      <button class="btn btn-lg btn-primary btn-block" type="button" id="schedule">Get Schedule</button>
		<div class="modal fade" id = "apply-modal">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        					<h4 class="modal-title">Tutor Application</h4>
      					</div>
      					<div class="modal-body tutor-apply panel panel-default span12">
		      				<input type="text" name="tutgtid" id="tutgtid" class="form-control" maxlength="9" disabled="disabled">
		      			    <input type="text" name="name" id="name" class="form-control" placeholder="Full Name">
		        			<input type="text" name="email" id="email" class="form-control" placeholder="example@gatech.edu">
		        			<input type="text" name="gpa" id="gpa" class="form-control" maxlength="4" placeholder="GPA (x.xx)">
		        			<input type="text" name="phone" id="phone" class="form-control" maxlength="10" placeholder="4049991234">
      					</div>
      					<div class="modal-footer">
        					<button type="submit" class="btn btn-primary" id="submit">Submit</button>
      					</div>
   				 </div><!-- /.modal-content -->
  			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<div class="modal fade" id = "schedule-modal">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        					<h4 class="modal-title"></h4>
      					</div>
      					<div class="modal-body tutor-schedule schedule-fill panel panel-default span12">
      					</div>
   				 </div><!-- /.modal-content -->
  			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		</div>
    </div> <!-- /container -->
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
     <script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
     	<script src="js/tutor-menu.js"></script>
  </body>
</html>
<?php

//=== Check if user is logged in ===
session_start();
if(!isset($_SESSION['myusername'])) //User is not logged in
{
  header("location:http://samkirsch.net/cs4400");
    die("You are not logged in");
}

include 'functions.php';


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
		      	<button class="btn btn-lg btn-primary btn-block" type="submit" id="button" name="button" value="0">Create Course Numbers Report</button>
		        <button class="btn btn-lg btn-primary btn-block" type="submit" id="button" name="button" value="1">Create Average Ratings Report</button>    	
			</div>
			<div class="reports" style="display: none">
			<table class="table">
				<thead>
					<tr>
						<td>School</td>
						<td>Number</td>
						<td># of Tutors</td>
						<td>Average Rating</td>
					</tr>
				</thead>
				<tbody>
			</div>
		</div>
    </div> <!-- /container -->


    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
     <script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
     	<script src="js/admin-menu.js"></script>
  </body>
</html>
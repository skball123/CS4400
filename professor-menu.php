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


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GT Tutor System</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    
    <link href="css/professor-menu.css" rel="stylesheet">
    
	<script src="js/professor-menu.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
     <div class="container">
	 <h2 class="form-heading">Recommendation</h2>
      <form class="form-signin" role="form" method="post" action="php/recommend.php">
        <div id="dropdown">
        	<input type="text" name="tutgtid" id="gtid" class="form-control" maxlength="9" placeholder="Tutor GTID" required autofocus>
        </div>
        <h5>Descriptive Evaluation</h5>
        <textarea class="form-control" required rows="4" maxlength="300" name="desc_eval"></textarea>
        
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
      	
      	<button class="btn btn-lg btn-primary btn-block" type="submit" >Submit Recommendation</button>
            	
      </form>

    </div> <!-- /container -->


    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
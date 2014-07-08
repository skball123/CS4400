<?php

//echo("<script>alert($_POST['course'])</script>");

header('Content-Type: application/json');
echo json_encode($_POST['course']);


?>
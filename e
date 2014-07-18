[1mdiff --git a/js/student-menu.js b/js/student-menu.js[m
[1mindex 1f2a78d..0298da4 100644[m
[1m--- a/js/student-menu.js[m
[1m+++ b/js/student-menu.js[m
[36m@@ -402,13 +402,12 @@[m [mfunction scheduleTutor(event){[m
 	//set up the modal pre-populate the course and tutor name[m
 	$("#tutgtid_sched").attr("value", $(event).attr("value") + " (" + $(event).attr("name") + ")");[m
 	$("#schedCourseName").attr("value", selected_course);[m
[31m-[m
[31m-	$("#schedule_tutor_modal").modal();[m
 	[m
 };[m
 [m
 // Function that is run after getting the tutor's availibilities[m
 function scheduleTutorP2(data) {[m
[32m+[m	[32mconsole.log(data);[m
 	$("#sched_table_div").empty()[m
 	var opener = '<table class="table table-hover">\[m
 						<thead>\[m
[36m@@ -497,6 +496,8 @@[m [mfunction scheduleTutorP2(data) {[m
 	} else {[m
 		alert("this tutor doesn't match your needs");[m
 	}[m
[32m+[m[41m	[m
[32m+[m	[32m$("#schedule_tutor_modal").modal();[m
 [m
 };[m
 [m
[1mdiff --git a/student-menu.php b/student-menu.php[m
[1mindex 23fa08d..ccafff5 100644[m
[1m--- a/student-menu.php[m
[1m+++ b/student-menu.php[m
[36m@@ -190,8 +190,8 @@[m [mecho('[m
 						</div>[m
 					</div>[m
 				</div>[m
[31m-				<div id="sched_table_div">[m
[31m-				</div>[m
[32m+[m			[32m</div>[m
[32m+[m			[32m<div id="sched_table_div">[m
 			</div>[m
 	      </div>[m
 	      <div class="modal-footer">[m

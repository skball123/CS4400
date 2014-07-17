var times = null;
var timeAdded = 0;
var stud_avail = null;
var selected_course = null;
var selected_tut_name = null;
var selected_tut_gtid = null;
var course_and_times = null;
var selected_time = null;
$(function(){
	stud_avail = null;
	$('.content').fadeIn();
	
	$(".btn-2").hide();
	$("#course_search").css({"width":"500px"});
	
	
	$(".search_btn").click(function(event) {
		resetModal();
		addListeners();
		$("#student_hours_modal").modal({
			keyboard: false,
			backdrop: 'static'
		});
	});
	
	$("#student_hours_modal_btn").click(function(event){
		$("#student_hours_modal").modal('hide');
		searchSubmit();
	});
	
	$("#add_time_btn").click(function(event){
		timeAdded++;
		addDayTime();
		
		if(timeAdded == 15){
			$("#add_time_btn").attr("disabled","disabled");
		}
		addListeners();
	});
	
	$("#rates_success_btn").click(function(event){
		$("#rate_success_modal").modal('hide');
	});
	
	$("#s_confirm_no").click(function(event){
		$("#confirm_sched_modal").modal('hide');
	});
	
	$("#rate_tutor_modal_btn").click(function(event){
		if(!$("#desc_eval").val()){
			$("#desc_eval").addClass('warning');
			return;
		}
		var toPost = $("#modal_rate_form").serialize();
		$.ajax({
		      type: 'POST',
		      //dataType: 'json',
		      url: 'php/rates.php',
		      data: toPost   
		  }).done(function(data) { 
			  	console.log(data);
			  	//alert(data); 
			  	afterPostRating(data);
		  	})
		    .fail(function() { alert("Failed to communicate"); })
		    .always(function() { /*alert("complete"); */});
	});
	
	/*$("#schedule_tutor_modal_btn").click(function(event){
		
		var toPost = $("#modal_schedule_form").serialize();
		$.ajax({
		      type: 'POST',
		      //dataType: 'json',
		      url: 'php/schedule-tutor-1.php',
		      data: toPost   
		  }).done(function(data) { 
			  	console.log(data);
			  	//alert(data); 
			  	afterPostSchedule(data);
		  	})
		    .fail(function() { alert("Failed to communicate"); })
		    .always(function() { /*alert("complete"); });
		
	});*/
	
	$("#s_confirm_yes").click(function(event){
		var toAppend = '<input type="text" style="display: none" name="selectedTime" value="' + selected_time + '">\
						<input type="text" style="display: none" name="tutgtid" value="' + $("#tutgtid_sched").attr("value") + '">\
						<input type="text" style="display: none" name="courseName" value="' + $("#schedCourseName").attr("value") + '">';
		$("#sched_post_data").append(toAppend);
		var toPost = $("#schedule_form").serialize();

		
		console.log(toPost);
		$.ajax({
		      type: 'POST',
		      //dataType: 'json',
		      url: 'php/schedule_tutor_2.php',
		      data: toPost   
		  }).done(function(data) { 
			  	console.log(data);
			  	//alert(data); 
			  	afterPostSchedule(data);
		  	})
		    .fail(function() { alert("Failed to communicate"); })
		    .always(function() { /*alert("complete");*/ });
		
	});
	
	$("#s_confirm_yes").click(function(event){
		$("#confirm_sched_modal").modal("hide");
	});
});

function addDayTime(){
	var newName = "day" + timeAdded;
	var toappend = '<div class="input-group time_input" style="display: none;">\
						<span class="input-group-btn">\
							<button type="button" class="btn btn-default day_btn" name="' + newName + '">Mo</button>\
						</span>\
						<input type="text" style="display: none" name="' + newName + '" class="' + newName + '" value="M">\
						<select name="time' + timeAdded + '" class="form-control">\
							<option value="7">7:00AM</option>\
							<option value="8">8:00AM</option>\
							<option value="9">9:00AM</option>\
							<option value="10">10:00AM</option>\
							<option value="11">11:00AM</option>\
							<option value="12">12:00PM</option>\
							<option value="13">1:00PM</option>\
							<option value="14">2:00PM</option>\
							<option value="15">3:00PM</option>\
							<option value="16">4:00PM</option>\
							<option value="17">5:00PM</option>\
							<option value="18">6:00PM</option>\
							<option value="19">7:00PM</option>\
							<option value="20">8:00PM</option>\
							<option value="21">9:00PM</option>\
							<option value="22">10:00PM</option>\
						</select>\
						\
					</div>'
					
	$(toappend).appendTo('#modal_form').show('slow');
}

function resetModal(){
	$("#modal_form").empty();
	$("#add_time_btn").removeAttr("disabled");
	timeAdded = 0;
	addDayTime();
}

function addListeners(){
	$(".day_btn").unbind("click");
	$(".day_btn").click(function(event){
		var day = $(event.target).html();
		switch(day){
			case "Mo": $(event.target).html("Tu");
						$('.' + $(event.target).attr("name")).attr("value", "T"); 
						break;
			case "Tu": $(event.target).html("We");
						$('.' + $(event.target).attr("name")).attr("value", "W"); 
						break;
			case "We": $(event.target).html("Th");
						$('.' + $(event.target).attr("name")).attr("value", "R"); 
						break;
			case "Th": $(event.target).html("Fr");
						$('.' + $(event.target).attr("name")).attr("value", "F"); 
						break;
			case "Fr": $(event.target).html("Sa");
						$('.' + $(event.target).attr("name")).attr("value", "S"); 
						break;
			case "Sa": $(event.target).html("Su");
						$('.' + $(event.target).attr("name")).attr("value", "Z"); 
						break;
			case "Su": $(event.target).html("Mo");
						$('.' + $(event.target).attr("name")).attr("value", "M"); 
						break;
		}
	});
}

function searchSubmit(){
	//store global variable for the course being searched
	selected_course = $("#course_search").val();
	
	var toAppend = '<input type="text" style="display: none" name="numTimes" value="' + timeAdded + '">';
	$(toAppend).appendTo('#modal_form');
	var cn = $("select, input").serialize();
	course_and_times = cn;
	$.ajax({
		      type: 'POST',
		      //dataType: 'json',
		      url: 'php/student.php',
		      data: cn   
		  }).done(function(data) { 
			  	console.log(data);
			  	//alert(data); 
			  	afterPostP1(data);
		  	})
		    .fail(function() { alert("Failed to communicate"); })
		    .always(function() { /*alert("complete"); */});
	
	// get the elements on the page
	/*var posting = $.post("php/student.php", cn, afterPostP1(data), "json");
	posting.always(afterPostP1(cn));
	
	 * // Debug for running the function without posting
	 * afterPostP1(cn);
	 */
};

var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;
 
    // an array that will be populated with substring matches
    matches = [];
 
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');
 
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        // the typeahead jQuery plugin expects suggestions to a
        // JavaScript object, refer to typeahead docs for more info
        matches.push({ value: str });
      }
    });
 
    cb(matches);
  };
};

$('#dropdown .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'states',
  displayKey: 'value',
  source: substringMatcher(states),
  templates: {
  	empty: [
  		'<div class="empty-message">',
      	'No classes match your current query',
      	'</div>'
  	].join('\n')
  }
 
});


function afterPostP1(data){
	if($(".btn-group-wrap").is(":visible")){
		// Move the search bar to the top of the screen
		$(".content").animate({
			"marginTop" : "0%",
		}, 1000, function(){
			$("#course_search").animate({"width":"450px"});
			$(".btn-2").fadeIn();
			afterPostP2(data);
		});
		
		// hide the search button
		$(".btn-group-wrap").fadeOut();	
	}else{
		// If the layout has already changed, simply call part 2
		afterPostP2(data);
	}
}

function afterPostP2(data){
	$(".tutor-list").fadeOut();
	$(".tutor-list").empty();
	
	var opener = '<table class="table table-hover">\
						<thead>\
							<tr>\
								<th>Name</th>\
								<th>Email</th>\
								<th>Prof Rating</th>\
								<th>Professors</th>\
								<th>Stud Rating</th>\
								<th>Students</th>\
								<th>Schedule</th>\
								<th>Rate</th>\
							</tr>\
						</thead>\
						<tbody>';
	
	/* Test debug row
	 var row = '<tr>\
				<td>John Smith</td>\
				<td>asdf@gremail.ch</td>\
				<td>9.248</td>\
				<td>13.41</td>\
				<td>4024</td>\
				<td>134</td>\
				<td> </td>\
				</tr>';*/
	
	
	var mondays = [];
	var tuesdays = [];
	var wednesdays = [];
	var thursdays = [];
	var fridays = [];
	try{
		var length = data.tutor.length;
	}catch(e){
		var length = 0;
	}
	if(length > 0){
		for(var i = 0; i < length; i++) { 
			/*
			var length2 = data.times[i].length;
			for(var j = 0; j < length2; j++) {
				var check = data.times[i][j][0] //gets day
				switch (check) {
					case 'M':
						mondays.push( '<button class="btn btn-info btn-mini">' + data.times[i][j].substring(2,data.times[0][0].length) + '</button>' );
						break;
					case 'T':
						tuesdays.push('<button class="btn btn-info btn-mini">' + data.times[i][j].substring(2,data.times[0][0].length) + '</button>');	
						break;
					case 'W':
						wednesdays.push('<button class="btn btn-info btn-mini">' + data.times[i][j].substring(2,data.times[0][0].length) + '</button>');
						break;	
					case 'R':
						thursdays.push('<button class="btn btn-info btn-mini">' + data.times[i][j].substring(2,data.times[0][0].length) + '</button>');
						break;
					case 'F':
						fridays.push('<button class="btn btn-info btn-mini">' + data.times[i][j].substring(2,data.times[0][0].length) + '</button>');	
						break;	
				}
			}
			*/
			
			if ( !data.email[i]) { continue; } 
			var row = '<tr><td>' + data.tutor[i][0] + '</td> <td>' + data.email[i] + '</td> <td>' + data.Pavg[i] + '</td> <td>' + data.Pnum[i] + '</td> <td>' + data.STavg[i] + '</td> <td>' + data.STnum[i] + '</td> <td>' + '<button class="btn btn-success" value="' + data.gtid[i] + '" name = "' + data.tutor[i][0] + '"  onclick="scheduleTutor(this)"><span class="glyphicon glyphicon-ok-sign"></span></button>' + '</td> <td>' + '<button class="btn btn-info" value="' + data.gtid[i] + '" name = "' + data.tutor[i][0] + '" onclick="rateTutor(this)"><span class="glyphicon glyphicon-comment"></span></button> </td> </tr>';
			opener = opener.concat(row);
		}
		
		var closer = "</tbody></table>";
		together = opener.concat(closer);
		$(".tutor-list").append(together);
		
	}else{
		//inform the user that the search yeilded no results
		$(".tutor-list").append('<h1>Sorry</h1><p>We could not find a tutor that fits your search criteria.</p>');
	}
	
	$(".tutor-list").fadeIn();
};

function afterPostRating(data){
	$("#rate_tutor_modal").modal('hide');
	
	//IF success then show this modal, currently no real feedback from the post so..... to do
	$("#rate_success_modal").modal();
	
};

function afterPostSchedule(data){
	$("#confirm_sched_modal").modal("hide");
	$("#schedule_tutor_modal").modal("hide");
	
	/* check the data to see if the posting was successful, 
	 * IF the student has already scheduled a timeslot for this course then it fails
	 * if there is another reason inform the student through the message
	 */
	 
	 if(data.success[0] == 1){
		$("#schedule_success_modal").modal();
		
	 
	 }else{
		$("#schedule_fail_modal").modal();
		$("#schedule_fail_message").text(data.message[0]);
	 }
};

function scheduleTutor(event){
	//clear the hidden tutorinfo div
	$('#tutor_info').empty();
	
	// post to the server the tutor gtid to get their time availabilities
	var toAppend = '<input id="tutinfo" type="text" style="display: none" name="tutgtid" value="' +  $(event).attr("value") + '">';
	$(toAppend).appendTo('#tutor_info');
	
	var cn = $('#tutinfo').serialize();
	cn = "" + cn + "&" + course_and_times;
	console.log(cn);
	
	$.ajax({
		      type: 'POST',
		      //dataType: 'json',
		      url: 'php/schedule_tutor_1.php',
		      data: cn   
		  }).done(function(data) { 
			  	console.log(data);
			  	//alert(data); 
			  	scheduleTutorP2(data);
		  	})
		    .fail(function() { alert("Failed to communicate"); })
		    .always(function() { /*alert("complete"); */});
	
	
	
	//set up the modal pre-populate the course and tutor name
	$("#tutgtid_sched").attr("value", $(event).attr("value") + " (" + $(event).attr("name") + ")");
	$("#schedCourseName").attr("value", selected_course);
	
};

// Function that is run after getting the tutor's availibilities
function scheduleTutorP2(data) {
	console.log(data);
	$("#sched_table_div").empty()
	var opener = '<table class="table table-hover">\
						<thead>\
							<tr>\
								<th>Day</th>\
								<th>Hour</th>\
							</tr>\
						</thead>\
						<tbody>';


	var day;
	var time;
	var o_day;
	var o_time;
	var row;
	try{
		var length = data.tutor.length;
	}catch(e){
		var length = 0;
	}
	if( length > 0 ){
		for( var i = 0; i < length; i++){
			day = data.daytime[i].substring(0,1);
			time = data.daytime[i].substring(1,3);
			o_day = day;
			o_time = time;
			switch(day){
				case "M": day = "Monday";
							break;
				case "T": day = "Tuesday";
							break;
				case "W": day = "Wednesday";
							break;
				case "T": day = "Thursday";
							break;
				case "F": day = "Friday";
							break;
				case "S": day = "Saturday";
							break;
				case "Z": day = "Sunday";
							break;
			}
			
			switch(time){
				case "07": time = "7:00 AM";
							break;
				case "08": time = "8:00 AM";
							break;
				case "09": time = "9:00 AM";
							break;
				case "10": time = "10:00 AM";
							break;
				case "11": time = "11:00 AM";
							break;
				case "12": time = "12:00 PM";
							break;
				case "13": time = "1:00 PM";
							break;
				case "14": time = "2:00 PM";
							break;
				case "15": time = "3:00 PM";
							break;
				case "16": time = "4:00 PM";
							break;
				case "17": time = "5:00 PM";
							break;
				case "18": time = "6:00 PM";
							break;
				case "19": time = "7:00 PM";
							break;
				case "20": time = "8:00 PM";
							break;
				case "21": time = "9:00 PM";
							break;
				case "22": time = "10:00 PM";
							break;
			}
			
			//populate table with the day times
			row = '<tr class="clickRow" id="' + o_day + o_time + '" name="' + o_day + o_time + '"><td>' + day + '</td> <td>' + time + '</td> </tr>';
			opener = opener.concat(row);
		
		}
		var closer = "</tbody></table>";
		var toAppend = opener.concat(closer);
		$('#sched_table_div').append(toAppend);
		addRowListener();
		
	} else {
		alert("this tutor doesn't match your needs");
	}
	
	$("#schedule_tutor_modal").modal();

};

function rateTutor(event){
	//pre-populate the course and tutor name
	$("#tutgtid").attr("value", $(event).attr("value") + " (" + $(event).attr("name") + ")");
	$("#rateCourseName").attr("value", selected_course);

	$("#rate_tutor_modal").modal();
};

function addRowListener(){
	$(".clickRow").click(function(event){
		selected_time = $(this).attr('id');
		console.log($(this).attr('id'));
		$("#confirm_sched_modal").modal();
	});
};


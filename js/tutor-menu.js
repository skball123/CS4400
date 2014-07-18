$(function(){
	
	$('.content').fadeIn();
	
	$("#tutgtid").attr("value",user);
	
	createAvailTable();
	
	$('.btn').click(function(event) {
		
		if( $(this).attr("id") == 'apply') {
			$('#apply-modal').modal("show");
		}
		if( $(this).attr("id") == 'schedule') {
			//alert($(this).attr("id"));
			//alert(user);
			
			$.ajax({
			      type: 'POST',
			      dataType: 'json',
			      url: 'php/tutorschedule.php',
			      data: user,   
			  }).done(function(data) { 
				  	//console.log(data);
				  	//alert(data); 
				  	afterPostP1(data);
			  	})
			    .fail(function() { alert("Failed to communicate"); })
			    .always(function() { /*alert("complete"); */});
			    
		}
		
	});
	
	$('#submit').click(function(event) {
		//var cn = { gtid: $('#tutgtid').attr("value"), name: $('#name').attr("value"), email: $('#email').attr("value"), gpa: $('#gpa').attr("value"), phone: $('#phone').attr("value") };
		var toPost = $('#tutor_apply_form').serialize();
		console.log(toPost);
		
		$.ajax({
			      type: 'POST',
			      dataType: 'json',
			      url: 'php/tutorapp.php',
			      data: toPost,   
			  }).done(function(data) { 
				  	console.log(data);
				  	//alert(data); 
				  	//afterPostP1(data);
			  	})
			    .fail(function() { alert("Failed to communicate"); })
			    .always(function() { /*alert("complete"); */});
	
	});
	
});


function afterPostP1(data){
	var opener = '<table class="table table-hover">\
							<thead>\
								<tr>\
									<th>Day</th>\
									<th>Time</th>\
									<th>Name</th>\
									<th>Email</th>\
									<th>Course</th>\
								</tr>\
							</thead>';
		var row = '<tbody>';
		var add = '';
		var remake = '';
		var mondays = [];
		var tuesdays = [];
		var wednesdays = [];
		var thursdays = [];
		var fridays = [];
		var time;
		
		var length = data.slothired.length;
		for(var i = 0; i < length; i++) {
			if ( (data.slothired[i][1] + data.slothired[i][2]) > 12) { time = (data.slothired[i][1] + data.slothired[i][2]) - 12 + ':00 PM'; } else { time = data.slothired[i][1] + data.slothired[i][2] + ':00 AM'; } if( (data.slothired[i][1] + data.slothired[i][2]) == 12 ) { time = data.slothired[i][1] + data.slothired[i][2] + ':00 PM'; }
			switch (data.slothired[i][0]) {
				case 'M':
					mondays.push('<tr><td>Monday</td><td>' + time + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
					break;
				case 'T':
					tuesdays.push('<tr><td>Tuesday</td><td>' + time + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
					break;
				case 'W':
					wednesdays.push('<tr><td>Wednesday</td><td>' + time + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
					break;
				case 'R':
					thursdays.push('<tr><td>Thursday</td><td>' + time + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
					break;
				case 'F':
					fridays.push('<tr><td>Friday</td><td>' + time + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
					break;				
			}
		}
		var mondayLength = mondays.length;
		var tuesdayLength = tuesdays.length;
		var wednesdayLength = wednesdays.length;
		var thursdayLength = thursdays.length;
		var fridayLength = fridays.length;
		for(var i = 0; i < mondayLength; i++) {
			add = mondays[i];
			row = row.concat(add);
		}
		for(var i = 0; i < tuesdayLength; i++) {
			add = tuesdays[i];
			row = row.concat(add);
		}
		for(var i = 0; i < wednesdayLength; i++) {
			add = wednesdays[i];
			row = row.concat(add);
		}
		for(var i = 0; i < thursdayLength; i++) {
			add = thursdays[i];
			row = row.concat(add);
		}
		for(var i = 0; i < fridayLength; i++) {
			add = fridays[i];
			row = row.concat(add);
		}
		$('.modal-title').empty();
		$('.modal-title').append('Tutor Schedule');
	
	var closer = "</tbody></table>";
	together = opener.concat(row,closer);
	$('.tutor-schedule').empty();	
	$('.tutor-schedule').append(together);
	$('#schedule-modal').modal("show");
	
	
}

function createAvailTable(){
	var opener = '<table class="table table-bordered">\
					<tr>\
						<th>Monday</th>\
						<th>Tuesday</th>\
						<th>Wednesday</th>\
						<th>Thursday</th>\
						<th>Friday</th>\
						<th>Saturday</th>\
						<th>Sunday</th>\
					</tr>'
	var day;
	var time;
	var row;
	var padZero;
	for(var j = 7; j <= 22; j++){
		switch(j){
			case 7: time = "7:00 AM"; break;
			case 8: time = "8:00 AM"; break;
			case 9: time = "9:00 AM"; break;
			case 10: time = "10:00 AM"; break;
			case 11: time = "11:00 AM"; break;
			case 12: time = "12:00 PM"; break;
			case 13: time = "1:00 PM"; break;
			case 14: time = "2:00 PM"; break;
			case 15: time = "3:00 PM"; break;
			case 16: time = "4:00 PM"; break;
			case 17: time = "5:00 PM"; break;
			case 18: time = "6:00 PM"; break;
			case 19: time = "7:00 PM"; break;
			case 20: time = "8:00 PM"; break;
			case 21: time = "9:00 PM"; break;
			case 22: time = "10:00 PM"; break;
		}
		row = "<tr>";
	
		for(var i = 0; i < 7; i++){
			switch(i){
				case 0: day = 'M'; break;
				case 0: day = 'T'; break;
				case 0: day = 'W'; break;
				case 0: day = 'R'; break;
				case 0: day = 'F'; break;
				case 0: day = 'S'; break;
				case 0: day = 'Z'; break;
			}
			
			//needed to make sure monday at 7 am is M07 and not M7
			if(j < 10){
				padZero = "0";
			}else{
				padZero = "";
			}
		
			row = row + '<td>\
							<div class="checkbox">\
							<label>\
							  <input type="checkbox" name="' + day + padZero + j + '">' + time +  '\
							</label>\
						  </div>\
						</td>';
		}
		opener = opener + row + '</tr>'
		
	}
				
	opener = opener + '</table>';
	$("#avail").append(opener);
	
};





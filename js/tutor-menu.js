$(function(){
	
	$('.content').fadeIn();
	
	$("#tutgtid").attr("value",user);
	
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
		toPost = $('#tutor_apply_form').serialize();
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
		
		var length = data.slothired.length;
		for(var i = 0; i < length; i++) {
			switch (data.slothired[i][0]) {
				case 'M':
					mondays.push('<tr><td>Monday</td><td>' + data.slothired[i][1] + data.slothired[i][2] + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
					break;
				case 'T':
					tuesdays.push('<tr><td>Tuesday</td><td>' + data.slothired[i][1] + data.slothired[i][2] + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
					break;
				case 'W':
					wednesdays.push('<tr><td>Wednesday</td><td>' + data.slothired[i][1] + data.slothired[i][2] + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
					break;
				case 'R':
					thursdays.push('<tr><td>Thursday</td><td>' + data.slothired[i][1] + data.slothired[i][2] + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
					break;
				case 'F':
					fridays.push('<tr><td>Friday</td><td>' + data.slothired[i][1] + data.slothired[i][2] + '</td><td>' + data.name[i] + '</td><td>' + data.email[i] + '</td><td>' + data.school[i] + ' ' + data.crn[i] + '</td></tr>');
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





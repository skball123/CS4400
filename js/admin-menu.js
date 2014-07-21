$(function(){
	$('.content').fadeIn();
	
	$('.btn').click(function(event) {
		//event.preventDefault();
		
		if( ($(this).attr("value") == 'rating') || ($(this).attr("value") == 'numbers') ) {
			if ( !($('#semester1').is(':checked')) ) {
				if( !($('#semester2').is(':checked')) ) {
					if( !($('#semester3').is(':checked')) ) { //if all boxes are unchecked
						alert('You did not select semester(s)');
						window.location = "http://samkirsch.net/cs4400/admin-menu.php";
						return;
					}
				}
			}
		}
		
		var gtid = (document.getElementById("tutgtid").value).split(" ");
		gtid = gtid[0];
		
		var cn = { button: $(this).attr("value"), checkbox1: $('#semester1').is(':checked'), checkbox2: $('#semester2').is(':checked'), checkbox3: $('#semester3').is(':checked'), GTID: gtid  };
		console.log(cn);
		$.ajax({
			      type: 'POST',
			      dataType: 'json',
			      url: 'php/admin.php',
			      data: cn,   
			  }).done(function(data) { 
				  	console.log(data);
				  	//alert(data); 
				  	afterPostP1(data);
			  	})
			    .fail(function() { alert("Failed to communicate"); })
			    .always(function() { /*alert("complete"); */});
		

	});
	
});


function afterPostP1(data){
	if($(".open").is(":visible")){
		// for now... no change to layout
		afterPostP2(data);
	}else{
		// If the layout has already changed, simply call part 2
		afterPostP2(data);
	}
}

function afterPostP2(data){
	if(data.type == 'rating') {
		var opener = '<table class="table table-hover">\
							<thead>\
								<tr>\
									<th>Course</th>\
									<th>Semester</th>\
									<th>GTA</th>\
									<th>Avg Rating</th>\
									<th>Non GTA</th>\
									<th>Avg Rating</th>\
								</tr>\
							</thead>';
		var row = '<tbody>';
		var numTA = 0.0;
		var avgTA = 0.0;
		var numGTA = 0.0;
		var avgGTA = 0.0;
		var calc1 = 0.0;
		var calc2 = 0.0;	
		var add = '';
		var remake = '';	
		var xcontinue = 0;			
	
		if( !(data.gradfall === undefined) ) {   //if undefined, then there were no results
			var length = data.gradfall.length;	
			for(var i = 0; i < length; i++ ) {
				data.gradfall[i].splice(2,0,'Fall');
				data.gradfall[i].splice(3,0,'GTA');
			}
			remake = data.gradfall;
		}	
		if( !(data.undgradfall === undefined) ) {
			var length = data.undgradfall.length;
			for(var i = 0; i < length; i++ ) {
				data.undgradfall[i].splice(2,0,'Fall');
				data.undgradfall[i].splice(3,0,'nTA');
			}
			if( remake.length == 0 ) {
				remake = data.undgradfall;
			}
			else {
				remake = remake.concat(data.undgradfall);	
			}
		}
		if( !(data.gradspring === undefined) ) {
			var length = data.gradspring.length;	
			for(var i = 0; i < length; i++ ) {
				data.gradspring[i].splice(2,0,'Spring');
				data.gradspring[i].splice(3,0,'GTA');
			}
			if( remake.length == 0 ) {
				remake = data.gradspring;
			}
			else {
				remake = remake.concat(data.gradspring);	
			}
		}	
		if( !(data.undgradspring === undefined) ) {
			var length = data.undgradspring.length;	
			for(var i = 0; i < length; i++ ) {
				data.undgradspring[i].splice(2,0,'Spring');
				data.undgradspring[i].splice(3,0,'nTA');
			}
			if( remake.length == 0 ) {
				remake = data.undgradspring;
			}
			else {
				remake = remake.concat(data.undgradspring);	
			}
		}
		if( !(data.gradsummer === undefined) ) {
			var length = data.gradsummer.length;	
			for(var i = 0; i < length; i++ ) {
				data.gradsummer[i].splice(2,0,'Summer');
				data.gradsummer[i].splice(3,0,'GTA');
			}
			if( remake.length == 0 ) {
				remake = data.gradsummer;
			}
			else {
				remake = remake.concat(data.gradsummer);	
			}
		}	
		if( !(data.undgradsummer === undefined) ) {
			var length = data.undgradsummer.length;	
			for(var i = 0; i < length; i++ ) {
				data.undgradsummer[i].splice(2,0,'Summer');
				data.undgradsummer[i].splice(3,0,'nTA');
			}
			if( remake.length == 0 ) {
				remake = data.undgradsummer;
			}
			else {
				remake = remake.concat(data.undgradsummer);	
			}
		}
		remake.sort();
		console.log(remake);
		var length = remake.length;
		for(var i = 0; i < length; i++) {
			
			if( i == 0 ) {
				if( remake[i][3] == 'GTA' ) {
					numGTA = parseFloat(remake[i][4]);
					avgGTA = numGTA * parseFloat((remake[i][5]));
					add = '<tr><td>' + remake[i][0] + ' ' + remake[i][1] + '</td> <td>' + remake[i][2] + '</td> <td>' + numGTA + '</td> <td>' + parseFloat(remake[i][5]).toPrecision(2) + '</td>';
					row = row.concat(add);
				}
				else {
					add = '<tr><td>' + remake[i][0] + ' ' + remake[i][1] + '</td> <td> 0 </td> <td>' + numGTA + '</td> <td>0.0</td>';
					row = row.concat(add);
				}
				if( remake[i+1][3] == 'nTA') {
						avgTA = avgTA + (parseFloat(remake[i+1][4]) * parseFloat(remake[i+1][5]));
						numTA = numTA + parseFloat(remake[i+1][4]);
						add = '<td>' + numTA + '</td><td>' + parseFloat(remake[i+1][5]).toPrecision(2) + '</td></tr>';
						row = row.concat(add);
						
						xcontinue = 1;
					}
				else {
					add = '<td>' + numTA + '</td><td>0.0</td></tr>';
					row = row.concat(add);
				}
			} //end if i = 0
			else {
				if (xcontinue) { xcontinue = 0; continue; }
				if( (remake[i][0] + remake[i][1]) == (remake[i-1][0] + remake[i-1][1]) ) { //if current class is same as last class
					if( remake[i][3] == 'GTA' ) {
						avgGTA = avgGTA + (parseFloat(remake[i][4]) * parseFloat(parseFloat(remake[i][5]))) ;
						numGTA = numGTA + parseFloat(remake[i][4]);
						add = '<tr><td></td> <td>' + remake[i][2] + '</td> <td>' + parseFloat(remake[i][4]) + '</td> <td>' + parseFloat(remake[i][5]).toPrecision(2) + '</td>';
						row = row.concat(add);
					}
					else {
						add = '<tr><td></td> <td>'  + remake[i][2] +  '</td> <td>0</td> <td>0.0</td>';
						row = row.concat(add);
					}
					if( !(remake[i+1] == undefined) ) {
						if( remake[i+1][3] == 'nTA') {
							avgTA = avgTA + (parseFloat(remake[i+1][4]) * parseFloat(remake[i+1][5]));
							numTA = numTA + parseFloat(remake[i+1][4]);
							add = '<td>' + numTA + '</td><td>' + parseFloat(remake[i+1][5]).toPrecision(2) + '</td></tr>';
							row = row.concat(add);
							
							xcontinue = 1;
						}
						else {
						add = '<td>' + numTA + '</td><td>0.0</td></tr>';
						row = row.concat(add);
						}
					}
					else {
						add = '<td>' + 0 + '</td><td>0.0</td></tr>';
						row = row.concat(add);
					}
				} // end if same check
				else {
					
					if( isNaN(avgGTA/numGTA) ) { calc1 =  "0.0"; } else { calc1 = (avgGTA/parseFloat(numGTA)).toPrecision(2); }
					if( isNaN(avgTA/numTA) ) { calc2 =  "0.0"; } else { calc2 = (avgTA/parseFloat(numTA)).toPrecision(2); } 
					add = '<tr> <td></td> <td>Avg</td> <td></td> <td>' + calc1 + '</td> <td></td> <td>' + calc2 + '</td> </tr>';
					row = row.concat(add);
					numTA = 0.0;
					avgTA = 0.0;
					numGTA = 0.0;
					avgGTA = 0.0;	
					
					if (xcontinue) { xcontinue = 0; continue; }
					if( remake[i][3] == 'GTA' ) {
						avgGTA = avgGTA + (parseFloat(remake[i][4]) * parseFloat(remake[i][5])) ;
						numGTA = numGTA + parseFloat(remake[i][4]);
						add = '<tr><td>'+ remake[i][0] + ' ' + remake[i][1]+ '</td> <td>' + remake[i][2] + '</td> <td>' + numGTA + '</td> <td>' + (parseFloat(remake[i][5])).toPrecision(2) + '</td>';
						row = row.concat(add);
					}
					else {
						add = '<tr><td>'+ remake[i][0] + ' ' + remake[i][1]+ '</td> <td>'  + remake[i][2] +  '</td> <td>0</td> <td>0.0</td>';
						row = row.concat(add);
					}
					if( !(remake[i+1] == undefined) ) {
						if( remake[i+1][3] == 'nTA') {
							avgTA = avgTA + (parseFloat(remake[i+1][4]) * parseFloat(remake[i+1][5]));
							numTA = numTA + parseFloat(remake[i+1][4]);
							add = '<td>' + numTA + '</td><td>' + parseFloat(remake[i+1][5]).toPrecision(2) + '</td></tr>';
							row = row.concat(add);
							
							xcontinue = 1;
						}
						else {
						add = '<td>' + numTA + '</td><td>0.0</td></tr>';
						row = row.concat(add);
						}
					}
					else {
						add = '<td>' + 0 + '</td><td>0.0</td></tr>';
						row = row.concat(add);
					}
				}
			}
		} //end for loop
		console.log(avgGTA);
		console.log(numGTA);
		console.log((avgGTA/numGTA).toFixed(2));
		if( isNaN(avgGTA/numGTA) ) { calc1 = "0.0"; } else { calc1 = (avgGTA/parseFloat(numGTA)).toPrecision(2); }
		if( isNaN(avgTA/numTA) ) { calc2 =  "0.0"; } else { calc2 = (avgTA/parseFloat(numTA)).toPrecision(2); } 
		add = '<tr> <td></td> <td>Avg</td> <td></td> <td>' + calc1 + '</td> <td></td> <td>' + calc2 + '</td> </tr>';
		row = row.concat(add);
		numTA = 0;
		avgTA = 0;
		numGTA = 0;
		avgGTA = 0;
		
		$('.modal-title').empty();
		$('.modal-title').append('Average Ratings Report');	
	}

	
	
	if(data.type == 'numbers') {
		var opener = '<table class="table table-hover">\
							<thead>\
								<tr>\
									<th>Course</th>\
									<th>Semester</th>\
									<th># Students</th>\
									<th># Tutors</th>\
								</tr>\
							</thead>';
		var row = '<tbody>';
		var add = '';
		var remake = '';
		var numstudents;
		var numtutors;
		var TotalT = 0;
		var TotalS = 0;
		
		if( !(data.fallnumbers == undefined)  ) {
			var length = data.fallnumbers.length;
			for(var i = 0; i < length; i++ ) {
				data.fallnumbers[i][4] = 'Fall';
			}
			remake = data.fallnumbers;
		}
		if( !(data.springnumbers == undefined)  ) {
			var length = data.springnumbers.length;
			for(var i = 0; i < length; i++ ) {
				data.springnumbers[i][4] = 'Spring';
			}
			if( remake.length == 0 ) {
				remake = data.springnumbers;
			}
			else {
				remake = remake.concat(data.springnumbers);	
			}
		}
		if( !(data.summernumbers == undefined)  ) {
			var length = data.summernumbers.length;
			for(var i = 0; i < length; i++ ) {
				data.summernumbers[i][4] = 'Summer';
			}
			if( remake.length == 0 ) {
				remake = data.summernumbers;
			}
			else {
				remake = remake.concat(data.summernumbers);	
			}
		}
		remake.sort();
		
		var length = remake.length;
		for(var i = 0; i < length; i++) {
			if( i == 0 ) {
				add = '<tr><td>' + remake[i][0] + ' ' + remake[i][1] + '</td> <td>' + (remake[i][5]) + '</td> <td>' + remake[i][2] + '</td> <td>' + remake[i][4] + '</td></tr>';
				row = row.concat(add);
				numstudents = parseFloat(remake[i][2]);
				numtutors = parseFloat(remake[i][4]);
			}
			else {
				if ( (remake[i][0] + remake[i][1]) == (remake[i-1][0] + remake[i-1][1]) ) { //if current class is same as last class
					add = '<tr><td> </td> <td>' + (remake[i][5]) + '</td> <td>' + remake[i][2] + '</td> <td>' + remake[i][4] + '</td></tr>';
					row = row.concat(add);
					numstudents = numstudents + parseFloat(remake[i][2]);
					numtutors = numtutors+ parseFloat(remake[i][4]);
				}
				else {
					TotalT+=numtutors;
					TotalS+=numstudents;
					add = '<tr><td> </td> <td>Total</td> <td>' + numstudents + '</td> <td>' + numtutors + '</td></tr>';
					row = row.concat(add);
					numstudents = 0;
					numtutors = 0;
					
					add = '<tr><td>' + remake[i][0] + ' ' + remake[i][1] + '</td> <td>' + (remake[i][5]) + '</td> <td>' + remake[i][2] + '</td> <td>' + remake[i][4] + '</td></tr>';
					row = row.concat(add);
					numstudents = parseFloat(remake[i][2]);
					numtutors = parseFloat(remake[i][4]);
					
				}
			}
		} 
		TotalT+=numtutors;
		TotalS+=numstudents;
		add = '<tr><td> </td> <td>Total</td> <td>' + numstudents + '</td> <td>' + numtutors + '</td></tr>';
		row = row.concat(add);
		add = '<tr><td> </td> <td>Grand Total</td> <td>' + TotalS + '</td> <td>' + TotalT + '</td></tr>';
		row = row.concat(add);
		$('.modal-title').empty();
		$('.modal-title').append('Course Numbers Report');
	}
	
	if(data.type == 'tutor') {
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
		if (!(data.slothired == undefined) ) {
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
		}
		$('.modal-title').empty();
		$('.modal-title').append('Tutor Schedule');
	
	}
	var closer = "</tbody></table>";
	together = opener.concat(row,closer);
	$('.reports').empty();	
	$('.reports').append(together);
		
	$('.modal').modal('show');
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
      	'No tutors match your current query',
      	'</div>'
  	].join('\n')
  }
 
});






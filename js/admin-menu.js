$(function(){
	$('.content').fadeIn();
	
	$('.btn').click(function(event) {
		//event.preventDefault();
		
		if ( !($('#semester1').is(':checked')) ) {
			if( !($('#semester2').is(':checked')) ) {
				if( !($('#semester3').is(':checked')) ) { //if all boxes are unchecked
					alert('You did not select semester(s)');
					window.location = "http://samkirsch.net/cs4400/admin-menu.php";
					return;
				}
			}
		}
		
		var gtid = (document.getElementById("tutgtid").value).split(" ");
		gtid = gtid[0];
		
		
		var cn = { button: $(this).attr("value"), checkbox1: $('#semester1').is(':checked'), checkbox2: $('#semester2').is(':checked'), checkbox3: $('#semester3').is(':checked'), GTID: gtid  };

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
		var numTA = 0;
		var numGTA = 0;	
		var remake = '';				
	
		if( !(data.gradfall == undefined) ) {   //if undefined, then there were no results
			var length = data.gradfall.length;	
			for(var i = 0; i < length; i++ ) {
				data.gradfall[i][4] = 'Fall';
				data.gradfall[i][5] = 'GTA';
			}
			remake = data.gradfall;
		}	
		if( !(data.undgradfall == undefined) ) {
			var length = data.undgradfall.length;
			for(var i = 0; i < length; i++ ) {
				data.undgradfall[i][4] = 'Fall';
				data.undgradfall[i][5] = 'nTA';
			}
			if( remake.length == 0 ) {
				remake = data.undgradfall;
			}
			else {
				remake = remake.concat(data.undgradfall);	
			}
		}
		if( !(data.gradspring == undefined) ) {
			var length = data.gradspring.length;	
			for(var i = 0; i < length; i++ ) {
				data.gradspring[i][4] = 'Spring';
				data.gradspring[i][5] = 'GTA';
			}
			if( remake.length == 0 ) {
				remake = data.gradspring;
			}
			else {
				remake = remake.concat(data.gradspring);	
			}
		}	
		if( !(data.undgradspring == undefined) ) {
			var length = data.undgradspring.length;	
			for(var i = 0; i < length; i++ ) {
				data.undgradspring[i][4] = 'Spring';
				data.undgradspring[i][5] = 'nTA';
			}
			if( remake.length == 0 ) {
				remake = data.undgradspring;
			}
			else {
				remake = remake.concat(data.ungradspring);	
			}
		}
		if( !(data.gradsummer == undefined) ) {
			var length = data.gradsummer.length;	
			for(var i = 0; i < length; i++ ) {
				data.gradsummer[i][4] = 'Summer';
				data.gradsummer[i][5] = 'GTA';
			}
			if( remake.length == 0 ) {
				remake = data.gradsummer;
			}
			else {
				remake = remake.concat(data.gradsummer);	
			}
		}	
		if( !(data.undgradsummer == undefined) ) {
			var length = data.undgradsummer.length;	
			for(var i = 0; i < length; i++ ) {
				data.undgradsummer[i][4] = 'Summer';
				data.undgradsummer[i][5] = 'nTA';
			}
			if( remake.length == 0 ) {
				remake = data.undgradsummer;
			}
			else {
				remake = remake.concat(data.undgradsummer);	
			}
		}
	}
	remake.sort();
	console.location(remake);
	
	
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
				add = '<tr><td>' + remake[i][0] + ' ' + remake[i][1] + '</td> <td>' + remake[i][4] + '</td> <td>' + remake[i][2] + '</td> <td>' + remake[i][3] + '</td></tr>';
				row = row.concat(add);
				numstudents = parseInt(remake[i][2]);
				numtutors = parseInt(remake[i][3]);
			}
			else {
				if ( (remake[i][0] + remake[i][1]) == (remake[i-1][0] + remake[i-1][1]) ) { //if current class is same as last class
					add = '<tr><td> </td> <td>' + remake[i][4] + '</td> <td>' + remake[i][2] + '</td> <td>' + remake[i][3] + '</td></tr>';
					row = row.concat(add);
					numstudents = numstudents + parseInt(remake[i][2]);
					numtutors = numtutors+ parseInt(remake[i][3]);
				}
				else {
					add = '<tr><td> </td> <td>Total</td> <td>' + numstudents + '</td> <td>' + numtutors + '</td></tr>';
					row = row.concat(add);
					numstudents = 0;
					numtutors = 0;
					
					add = '<tr><td>' + remake[i][0] + ' ' + remake[i][1] + '</td> <td>' + remake[i][4] + '</td> <td>' + remake[i][2] + '</td> <td>' + remake[i][3] + '</td></tr>';
					row = row.concat(add);
					numstudents = parseInt(remake[i][2]);
					numtutors = parseInt(remake[i][3]);
				}
			}
		} 
		add = '<tr><td> </td> <td>Total</td> <td>' + numstudents + '</td> <td>' + numtutors + '</td></tr>';
		row = row.concat(add);
		$('.modal-title').empty();
		$('.modal-title').append('Course Numbers Report');
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






var times = null;

$(function(){
	$('.content').fadeIn();
	
	$(".btn-2").hide();
	$("#course_search").css({"width":"500px"});
	
	
	$(".btn").click(function(event) {
		
		$("#student_hours_modal").modal({
			keyboard: false,
			backdrop: 'static'
		});
	});
	
	$("#student_hours_modal_btn").click(function(event){
		$("#student_hours_modal").modal('hide');
		searchSubmit();
	});
	
	$(".day_btn").click(function(event){
		var day = $(event.target).html();
		switch(day){
			case "Mo": $(event.target).html("Tu"); break;
			case "Tu": $(event.target).html("We"); break;
			case "We": $(event.target).html("Th"); break;
			case "Th": $(event.target).html("Fr"); break;
			case "Fr": $(event.target).html("Sa"); break;
			case "Sa": $(event.target).html("Su"); break;
			case "Su": $(event.target).html("Mo"); break;
		}
	});

});

function searchSubmit(){
	var cn = $("#course_search").serialize();
		
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
								<th> </th>\
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
	var length = data.tutor.length;
	for(var i = 0; i < length; i++) { 
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
		var row = '<tr><td>' + data.tutor[i][0] + '</td> <td>' + data.tutor[i][1] + '</td> <td>' + mondays.join('<br>') + '</td> <td>' + tuesdays.join('<br>') + '</td> <td>' + wednesdays.join('<br>') + '</td> <td>' + thursdays.join('<br>') + '</td> <td>' + fridays.join('<br>') + '</td> </tr>';
	}
	
	var closer = "</tbody></table>";
	var together = opener.concat(row, closer);
	$(".tutor-list").append(together);
	$(".tutor-list").fadeIn();
};



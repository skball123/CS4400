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
		
		
		var cn = { button: $(this).attr("value"), checkbox1: $('#semester1').is(':checked'), checkbox2: $('#semester2').is(':checked'), checkbox3: $('#semester3').is(':checked') };

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
		// hide the search button
		$(".open").fadeOut();	
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
	
		if( !(data.gradfall == undefined) ) {   //if undefined, then there were no results
			var length = data.gradfall.length;	

		}	
		if( !(data.undgradfall == undefined) ) {
			var length = data.undgradfall.length;
				
		}
		if( !(data.gradspring == undefined) ) {
			var length = data.gradspring.length;	
			
		}	
		if( !(data.undgradspring == undefined) ) {
			var length = data.undgradspring.length;	
			
		}
		if( !(data.gradsummer == undefined) ) {
			var length = data.gradsummer.length;	
			
		}	
		if( !(data.undgradsummer == undefined) ) {
			var length = data.undgradsummer.length;	
			
		}
	}
	else {
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
		
		if( !(data.fallnumbers == undefined)  ) {
			var length = data.fallnumbers.length;
			
		}
		if( !(data.springnumbers == undefined)  ) {
			var length = data.springnumbers.length;
			
		}
		if( !(data.summernumbers == undefined)  ) {
			var length = data.springnumbers.length;
			
		}
		
		
					
	}
	var closer = "</tbody></table>";
		together = opener.concat(row,closer);	
		$('.reports').append(together);
		$('.reports').fadeIn();
};



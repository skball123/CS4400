$(function(){
	$('.content').fadeIn();
	
	$('.btn').click(function(event) {
		//event.preventDefault();
		
		var cn = { button: $('.btn').val(), checkbox1: $('#semester1').is(':checked'), checkbox2: $('#semester2').is(':checked'), checkbox3: $('#semester3').is(':checked') };

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
	if( !(data.gradfall == undefined) ) {
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
	
	var closer = "</tbody></table>";
	$('.reports').append(closer);
	$('.reports').fadeIn();
	
	
};



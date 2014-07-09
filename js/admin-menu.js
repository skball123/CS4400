$(function(){
	$('.content').fadeIn();
	
	$('.btn').click(function(event) {
		//event.preventDefault();
		
		
		$.ajax({
			      type: 'POST',
			      //dataType: 'json',
			      url: 'php/admin.php',
			      data: { button: $('.btn').val(), checkbox1: $('#semester1').is(':checked'), checkbox2: $('#semester2').is(':checked'), checkbox3: $('#semester3').is(':checked') },   
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
	alert(data);
};



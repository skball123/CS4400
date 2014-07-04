$(function(){
	$('.content').fadeIn();
	
	$(".btn-2").hide();
	$("#course_search").css({"width":"500px"});
	$(".btn").click(function(event) {
		//event.preventDefault();
		
		var cn = $("#search-form").val();
		cn = cn.replace(/\s/g, '');
		
		
		// get the elements on the page
		var posting = $.post("student.php", { class_name: cn }, afterPost(data), "json");
		
		/*
		 * // Debug for running the function without posting
		 * afterPostP1(cn);
		 */
	});

	
	
});

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
		}, 2000, function(){
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
	
	alert(data);
};



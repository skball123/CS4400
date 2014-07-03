$(function(){
	$('.content').fadeIn();
	
	
	$("#search-form").submit(function(event) {
		event.preventDefault();
		
		var cn = $("#search-form").val();
		
		// get the elements on the page
		var posting = $.post("student.php", { class_name: cn });
		
		
		posting.done(afterPost(data));
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

function afterPost(data){
	alert("Posted");
};



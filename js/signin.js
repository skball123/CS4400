function CheckLength(name) {

			var password = document.getElementById(name).value;

			if (password.length < 9);

				//alert('Enter Valid GTID');
}
$(document).ready(function () {

    $('.form-signin').validate({ // initialize the plugin
        rules: {
            gtid: {
            	required: true,
                minlength: 9
            }
        },
        messages: {
        	gtid: {
        		required: "GTID",
        		minlength: jQuery.format("Must enter valid GTID")
        	}
        }
    });

});
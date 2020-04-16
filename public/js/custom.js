$(document).ready( function() {
	$(document).scroll(function () {
	    var hp_nav = $('.homepage .navbar-default');
	    if ($(this).scrollTop() > hp_nav.height()+20) {
	    	hp_nav.css('background', 'linear-gradient(to right,#DEE7ED ,#3299be,#dee7ed)');
	    } else {
	    	hp_nav.css('background', 'transparent');
	    }
	});
});
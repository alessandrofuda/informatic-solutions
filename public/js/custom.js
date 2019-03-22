$(document).ready( function() {
	var windowHeight = $(window).height();
	console.log(windowHeight);
	$('body, body > div').css({'min-height': windowHeight+'px'});
	var containerHeight = windowHeight - $('nav').height() - $('footer').outerHeight(true);
	$('#app > .container, #app > .container-fluid').css('min-height', containerHeight+'px');
});
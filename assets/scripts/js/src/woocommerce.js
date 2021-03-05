var $ = require('jquery');

$(document).ready(function(){
	
	$('.cart-widget-link').click(function(e){
		console.log('clicked');
	});
	
	$('.cart-widget-link').on('click', function(e){
		console.log('click');
		e.preventDefault();
		var url = $(this).attr('href');
		console.log(url);
		window.location.href = url;
	});
});
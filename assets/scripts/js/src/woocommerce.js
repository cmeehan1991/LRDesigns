var $ = require('jquery');

$(document).ready(function(){
	
	$('.cart-widget-link').on('click', function(e){
		e.preventDefault();
		
		//var url = $(this).attr('href');
		//console.log(url);
		//window.location.href = url;
	});
});
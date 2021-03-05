var $ = require('jquery');
var list = require('list.js'); 
var retailers = [];

var mapboxgl = require('mapbox-gl/dist/mapbox-gl.js');
var map;

mapboxgl.accessToken = 'pk.eyJ1IjoiY29ubm9ybWVlaGFuMTk5MSIsImEiOiJja2x3aDBjcmQwaXlnMnJqamEyOTh6Y3h2In0.gQD6bVq5_nfZ58FKB3eJYg';

$(document).ready(function(){

	if($('.vendors-map')){
		getUserLocation();		
	}
	
});

function getUserLocation(){
	if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(setupMap, handleLocationError);
	
	}else{
		console.log("Not supported");
	}
}

function handleLocationError(error){
	// force the location
	var position = {
		coords: {
			latitude: -79.50048,
			longitude: 36.08392
		}
	};
	
	setupMap(position);
}

function setupMap(position){

	if(position){

		map = new mapboxgl.Map({
			container:'vendor-map', 
			style: 'mapbox://styles/mapbox/streets-v11',
			center: [position.coords.longitude, position.coords.latitude],
			zoom: 9
		});
		/*
		var marker = new mapboxgl.Marker()
		.setLngLat([position.coords.longitude, position.coords.latitude])
		.addTo(map);
		*/
	}
		
	$.getJSON(rest_api.get_vendors)
	.fail(function(error){
		console.log(error);
	})
	.done(function(response){
		lr_vendor_list(response);
	});

}

function focusMap(id){
	console.log(retailers[id]);
	
	var retailer = retailers[id];
	
	map.flyTo({
		center: [retailer.lng, retailer.lat], 
		zoom: 12
	});
}


function lr_vendor_list(vendors){
	
	
	var options = {
		valueNames: ['name', 'street_address', 'city', 'state', 'postal_code', 'telephone', 'website', 'vendor_id', {data: ['id']}],
		item: '<li class="vendor-list--item" data-id=""> <span class="vendor_id" hidden></span> <h3 class="name"></h3><p class="address"><span class="street_address"></span><br/><span class="city"></span>, <span class="state"></span> <span class="postal_code"></span></p><o><span class="telephone"></span><br/><span class="website"></span></p></li>'
	};
	
	var values = [];
	
	$.each(vendors, function(k,v){
		var streetAddress = v.primary_address;
		
		if(v.secondary_address){
			streetAddress += "<br/>" + v.secondary_address;
		}
				
		var phone = 'Phone: <a href="tel:' + v.phone_number + '">' + v.phone_number + '</a>';
		
		var website = 'Website: <a href="' + v.website + '">' + v.website + '</a>';
	
		retailers[v.vendor_id] = v;
				
		values.push({
			name: v.display_name, 
			street_address: streetAddress,
			city: v.city, 
			state: v.state,
			postal_code: v.postal_code,
			telephone: phone,
			website: website,
			id:v.vendor_id
		});
		
		
		var lat = parseFloat(v.lat);
		var lng = parseFloat(v.lng);
		
		var marker = new mapboxgl.Marker()
		.setLngLat([lng, lat])
		.addTo(map);
		
		
		
	});

	var vendorsList = list('vendors-list', options, values);
	

	$('.loading-section').hide();
	
	$('.vendor-list--item').on('click', function(){
		focusMap($(this).attr('data-id'));
	});
	
}
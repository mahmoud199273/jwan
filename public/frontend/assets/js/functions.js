/*   login toggle    */
function toggleLogin(slideOut,slideIn){
	$(slideOut).slideUp(500,function(){
		$(slideIn).slideDown(500);
	});
	
}
$('#forget').click(function(){
	toggleLogin('.mainLogin','.forgetPass');
});
$('#backLogin,#backLogin2').click(function(){
	toggleLogin('.forgetPass','.mainLogin');
});
/*$(document).ready(function() {
	$('.file-upload').file_upload();
});*/
/*   open chat     */
function openCloseDiv(closd,opnd,biggerDiv){
	$(closd).animate({width:'toggle'},500,function(){
		$(opnd).animate({width:'toggle'},500);
	});
}
$('.openChatPeople').click(function(){
	openCloseDiv('.openChatPeople','.chatPeople');
});
$('.closeChat').click(function(){
	openCloseDiv('.chatPeople','.openChatPeople');
});
/* open close search */
$('.openSearch').click(function(){
	openCloseDiv('.openSearch','.customSearch');
});
$('.closeSearch').click(function(){
	openCloseDiv('.customSearch','.openSearch');
});
/*      chart      */

if ($('#chart').length) {


$.ajax({
	url: base_url+'/all/prices?type='+type_filter+'&city='+city_filter+'&district_id='+district_filter,
	type: 'GET',
	success: function(data ){

var config = {
	type: 'line',
	data: {
		labels: data.monthes,
		datasets: data.data
	},
	options: {
		responsive: true,
		tooltips: {
			mode: 'index',
			intersect: false,
		},
		hover: {
			mode: 'nearest',
			intersect: true
		},
		scales: {
			xAxes: [{
				display: true,
				scaleLabel: {
					display: false,
					labelString: 'Month'
				}
			}],
			yAxes: [{
				display: true,
				scaleLabel: {
					display: false,
					labelString: 'Value'
				}
			}]
		}
	}
};
var ctx = document.getElementById('chart').getContext('2d');
window.myLine = new Chart(ctx, config);

},
	error : function(e){
		console.log(e);
	},
});
}

/*    hover home services    */
function scale(scaleout,scalein){
	$(scaleout).hide( "clip", {}, 400,function(){
		$(scalein).show("clip",{}, 400);
	});
}
$('.service').mouseenter(function(){
	scale($(this).find('.icon1'),$(this).find('.icon2'));
}).mouseleave(function(){
	scale($(this).find('.icon2'),$(this).find('.icon1'));
});
/*     toggle blue heart      */
$(document).on('click','.homeImg i',function(){
	$(this).toggleClass('clicked');
	ad_id = $(this).attr('data-id');
	  $.ajax({
	        url: base_url+'/favorite/'+ ad_id,
	        type: 'POST',
	        data: {'_token': $('meta[name="csrf-token"]').attr('content') },
	        success: function( msg ) {
	            if ( msg.status === 'success' ) {
	             }
	    },
	    error : function(){

	    },
	  });
});
$(document).on('click','.clickLike',function(){
	$(this).toggleClass('far fas');
	ad_id = $(this).attr('data-id');
	  $.ajax({
	        url: base_url+'/favorite/'+ ad_id,
	        type: 'POST',
	        data: {'_token': $('meta[name="csrf-token"]').attr('content') },
	        success: function( msg ) {
	            if ( msg.status === 'success' ) {
	             }
	    },
	    error : function(){

	    },
	  });
});
/*   show welcome screen    */
/*$(document).on('click','#welcome',function(){
	toggleLogin('#registerCarousel','.welcome');
});*/
/*      confirm        */

$(function(){
	/* tooltip */
	 $('.pop').popover({
        html: true,
        trigger: 'manual',
        container: $(this).attr('id'),
        content: function () {
            $return = '<div class="hover-hovercard"></div>';
        }
    }).on("mouseenter", function () {
        var _this = this;
        $(this).popover("show");
        $(this).siblings(".popover").on("mouseleave", function () {
            $(_this).popover('hide');
        });
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide")
            }
        }, 100);
    });
	/* $('[data-toggle="tooltip"]').tooltip({
	 	html:true})
	 .on("mouseenter", function () {
        var _this = this;
        $(this).tooltip("show");
        $(".tooltip").on("mouseleave", function () {
            $(_this).tooltip('hide');
        });
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".tooltip:hover").length) {
                $(_this).tooltip("hide");
            }
        }, 300);
});*/
	 
	/*var notify = $.notify('<p>اختبار</p>', {
		allow_dismiss: false,
		delay:false,
		type: 'danger',
		showProgressbar: false,
		timer: 1000,
		animate: {
			enter: 'animated fadeInDown',
			exit: 'animated fadeOutUp'
		},
		placement: {
			from: "top",
			align: "left"
		},
		template: '<div id="notifyBalance" data-notify="container" class="col-xs-11 col-sm-3 alert alert-danger" role="alert">' +
		'<button type="button" id="notifyDismiss" class="close">×</button>' +
		'<p data-notify="message">لقد نفذ رصيدكم من الأعلانات برجاء اعادة شحن الباقه</p>' +
	'</div>' 
	});
	$('#notifyDismiss').click(function(){
		$('#notifyBalance').slideUp();
	});
	//$('#notifyBalance').hide();
	$('#notifyTrigger').click(function(){
		$('#notifyBalance').show();
	});*/
	/* notify setting */
	$('#closeNotify').click(function(){
		$(this).parent().hide('slow');
	});
	$('#notifyTrigger').click(function(){
		$('.notify').show('slow');
	});
	/* more text */
	if($('#less').length){
		var adjustheight = 60;
		var moreText = 'المزيد';
		var lessText = 'اقل';
		$("#less #more").each(function(){
			if ($(this).height() > adjustheight){
				$(this).css('height', adjustheight).css('overflow', 'hidden');
				$(this).parent("#less").append
				('<a style="cursor:pointer" class="moreTextBtn">' + moreText + '</a>');
			}
		});
		$(".moreTextBtn").click(function() {
			if ($(this).prev().css('overflow') == 'hidden')
			{
				$(this).prev().css('height', 'auto').css('overflow', 'visible');
				$(this).text(lessText);
			}
			else {
				$(this).prev().css('height', adjustheight).css('overflow', 'hidden');
				$(this).text(moreText);
			}
		});
	}
	/* details Carousel */
	if($('#detailsCarou').length){
		$('#detailsCarou .item:first-child').addClass('active');
	}
	if($('.chat .chatPeople').length){
		$('.chat .chatPeople .nav li:first-child').addClass('active');
		$('.chat .tab-content .openChat:first-child').addClass('in active');
	}
	//contact map
	
	var myCenter = new google.maps.LatLng(30.7915709, 30.993263100000036);
	if($('#mapContact').length){
		function initMap() {
			var mapProp = {
				center:myCenter,
				zoom:10,
				draggable:true,
				mapTypeId:google.maps.MapTypeId.ROADMAP,
				styles:[
				{
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#f5f5f5"
					}
					]
				},
				{
					"elementType": "labels.icon",
					"stylers": [
					{
						"visibility": "off"
					}
					]
				},
				{
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#616161"
					}
					]
				},
				{
					"elementType": "labels.text.stroke",
					"stylers": [
					{
						"color": "#f5f5f5"
					}
					]
				},
				{
					"featureType": "administrative.land_parcel",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#bdbdbd"
					}
					]
				},
				{
					"featureType": "poi",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#eeeeee"
					}
					]
				},
				{
					"featureType": "poi",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#757575"
					}
					]
				},
				{
					"featureType": "poi.park",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#e5e5e5"
					}
					]
				},
				{
					"featureType": "poi.park",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#9e9e9e"
					}
					]
				},
				{
					"featureType": "road",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#ffffff"
					}
					]
				},
				{
					"featureType": "road.arterial",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#757575"
					}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#dadada"
					}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#616161"
					}
					]
				},
				{
					"featureType": "road.local",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#9e9e9e"
					}
					]
				},
				{
					"featureType": "transit.line",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#e5e5e5"
					}
					]
				},
				{
					"featureType": "transit.station",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#eeeeee"
					}
					]
				},
				{
					"featureType": "water",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#c9c9c9"
					}
					]
				},
				{
					"featureType": "water",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#9e9e9e"
					}
					]
				}
				]
			};
			var map = new google.maps.Map(document.getElementById("mapContact"),mapProp);
			var marker = new google.maps.Marker({position: myCenter, map: map});
			iconOptions = {
				path:'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
				scale: 1,
				strokeColor: 'white',
				strokeOpacity: 1,
				strokeFillColor: '#fff',
				strokeWeight: 1.0,
				fillColor:'#34495e',
				fillOpacity: 1
			}
			marker.setIcon(iconOptions);
			marker.setMap(map);
		}
		google.maps.event.addDomListener(window, 'load', initMap);
	}
	//map

	if($('#map').length){

		var centerDefault = new google.maps.LatLng(24.71339137649578,46.675207734326136);
		function initialize() {
			var mapProp = {
				center:centerDefault,
				zoom:10,
				draggable:true,
				mapTypeId:google.maps.MapTypeId.ROADMAP,
				styles:[
				{
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#f5f5f5"
					}
					]
				},
				{
					"elementType": "labels.icon",
					"stylers": [
					{
						"visibility": "off"
					}
					]
				},
				{
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#616161"
					}
					]
				},
				{
					"elementType": "labels.text.stroke",
					"stylers": [
					{
						"color": "#f5f5f5"
					}
					]
				},
				{
					"featureType": "administrative.land_parcel",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#bdbdbd"
					}
					]
				},
				{
					"featureType": "poi",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#eeeeee"
					}
					]
				},
				{
					"featureType": "poi",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#757575"
					}
					]
				},
				{
					"featureType": "poi.park",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#e5e5e5"
					}
					]
				},
				{
					"featureType": "poi.park",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#9e9e9e"
					}
					]
				},
				{
					"featureType": "road",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#ffffff"
					}
					]
				},
				{
					"featureType": "road.arterial",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#757575"
					}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#dadada"
					}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#616161"
					}
					]
				},
				{
					"featureType": "road.local",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#9e9e9e"
					}
					]
				},
				{
					"featureType": "transit.line",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#e5e5e5"
					}
					]
				},
				{
					"featureType": "transit.station",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#eeeeee"
					}
					]
				},
				{
					"featureType": "water",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#c9c9c9"
					}
					]
				},
				{
					"featureType": "water",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#9e9e9e"
					}
					]
				}
				]
			};
			var marker = new google.maps.Marker({
				position:centerDefault,
				map: map,
				draggable:true
			});
			var map = new google.maps.Map(document.getElementById("map"),mapProp);
			/*    map search   */
			/* get marker position after drag */
			// Create the search box and link it to the UI element.
			var input = document.getElementById('searchMap');
			var searchBox = new google.maps.places.SearchBox(input);
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	        // Bias the SearchBox results towards current map's viewport.
	        map.addListener('bounds_changed', function() {
	        	searchBox.setBounds(map.getBounds());
	        });

	        var markers = [];
	        markers.push(marker);
	        // Listen for the event fired when the user selects a prediction and retrieve
	        // more details for that place.
	        searchBox.addListener('places_changed', function() {
	        	var places = searchBox.getPlaces();

	        	if (places.length == 0) {
	        		return;
	        	}

		        // Clear out the old markers.
		        markers.forEach(function(marker) {
		        	marker.setMap(null);
		        });
		        markers = [];

		        // For each place, get the icon, name and location.
		        var bounds = new google.maps.LatLngBounds();
		        places.forEach(function(place) {
		        	if (!place.geometry) {
		        		console.log("Returned place contains no geometry");
		        		return;
		        	}

	            // Create a marker for each place.
	            /*marker = new google.maps.Marker({
					map: map,
		            title: place.name,
		            position: place.geometry.location,
		            draggable:true,
		            icon:iconOptions
		        });*/
		        addMarker(place.geometry.location, place.name, map);
		        markers.push(marker);

		        if (place.geometry.viewport) {
		              // Only geocodes have viewport.
		              bounds.union(place.geometry.viewport);
		          } else {
		          	bounds.extend(place.geometry.location);
		          }
		      });
		        map.fitBounds(bounds);
		    });
	        google.maps.event.addListener(marker, 'dragend', function (event) {
	        	document.getElementById("lat").value = this.getPosition().lat();
	        	document.getElementById("lng").value = this.getPosition().lng();
	        });
	        function handleEvent(event) {
	        	document.getElementById('lat').value = event.latLng.lat();
	        	document.getElementById('lng').value = event.latLng.lng();
	        }
	        function addMarker(latlng,title,map) {
	        	var marker = new google.maps.Marker({
	        		position: latlng,
	        		map: map,
	        		title: title,
	        		draggable:true,
	        		icon:iconOptions
	        	});

	        	marker.addListener('drag', handleEvent);
	        	marker.addListener('dragend', handleEvent);
	        }
	        iconOptions = {
	        	path:'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
	        	scale: 1,
	        	strokeColor: 'white',
	        	strokeOpacity: 1,
	        	strokeFillColor: '#fff',
	        	strokeWeight: 1.0,
	        	fillColor:'#34495e',
	        	fillOpacity: 1
	        }
	        marker.setIcon(iconOptions);
	        marker.setMap(map);
	    }
	    google.maps.event.addDomListener(window, 'load', initialize);
	}

	//edit-map
	if($('#edit_map').length){

		var centerDefault = new google.maps.LatLng(lat,lng);
		function initialize() {
			var mapProp = {
				center:centerDefault,
				zoom:10,
				draggable:true,
				mapTypeId:google.maps.MapTypeId.ROADMAP,
				styles:[
				{
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#f5f5f5"
					}
					]
				},
				{
					"elementType": "labels.icon",
					"stylers": [
					{
						"visibility": "off"
					}
					]
				},
				{
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#616161"
					}
					]
				},
				{
					"elementType": "labels.text.stroke",
					"stylers": [
					{
						"color": "#f5f5f5"
					}
					]
				},
				{
					"featureType": "administrative.land_parcel",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#bdbdbd"
					}
					]
				},
				{
					"featureType": "poi",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#eeeeee"
					}
					]
				},
				{
					"featureType": "poi",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#757575"
					}
					]
				},
				{
					"featureType": "poi.park",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#e5e5e5"
					}
					]
				},
				{
					"featureType": "poi.park",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#9e9e9e"
					}
					]
				},
				{
					"featureType": "road",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#ffffff"
					}
					]
				},
				{
					"featureType": "road.arterial",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#757575"
					}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#dadada"
					}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#616161"
					}
					]
				},
				{
					"featureType": "road.local",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#9e9e9e"
					}
					]
				},
				{
					"featureType": "transit.line",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#e5e5e5"
					}
					]
				},
				{
					"featureType": "transit.station",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#eeeeee"
					}
					]
				},
				{
					"featureType": "water",
					"elementType": "geometry",
					"stylers": [
					{
						"color": "#c9c9c9"
					}
					]
				},
				{
					"featureType": "water",
					"elementType": "labels.text.fill",
					"stylers": [
					{
						"color": "#9e9e9e"
					}
					]
				}
				]
			};
			var marker = new google.maps.Marker({
				position:centerDefault,
				map: map,
				draggable:true
			});
			var map = new google.maps.Map(document.getElementById("edit_map"),mapProp);
			/*    map search   */
			/* get marker position after drag */
			// Create the search box and link it to the UI element.
			var input = document.getElementById('searchMap');
			var searchBox = new google.maps.places.SearchBox(input);
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	        // Bias the SearchBox results towards current map's viewport.
	        map.addListener('bounds_changed', function() {
	        	searchBox.setBounds(map.getBounds());
	        });

	        var markers = [];
	        markers.push(marker);
	        // Listen for the event fired when the user selects a prediction and retrieve
	        // more details for that place.
	        searchBox.addListener('places_changed', function() {
	        	var places = searchBox.getPlaces();

	        	if (places.length == 0) {
	        		return;
	        	}

		        // Clear out the old markers.
		        markers.forEach(function(marker) {
		        	marker.setMap(null);
		        });
		        markers = [];

		        // For each place, get the icon, name and location.
		        var bounds = new google.maps.LatLngBounds();
		        places.forEach(function(place) {
		        	if (!place.geometry) {
		        		console.log("Returned place contains no geometry");
		        		return;
		        	}

	            // Create a marker for each place.
	            /*marker = new google.maps.Marker({
					map: map,
		            title: place.name,
		            position: place.geometry.location,
		            draggable:true,
		            icon:iconOptions
		        });*/
		        addMarker(place.geometry.location, place.name, map);
		        markers.push(marker);

		        if (place.geometry.viewport) {
		              // Only geocodes have viewport.
		              bounds.union(place.geometry.viewport);
		          } else {
		          	bounds.extend(place.geometry.location);
		          }
		      });
		        map.fitBounds(bounds);
		    });
	        google.maps.event.addListener(marker, 'dragend', function (event) {
	        	document.getElementById("lat").value = this.getPosition().lat();
	        	document.getElementById("lng").value = this.getPosition().lng();
	        });
	        function handleEvent(event) {
	        	document.getElementById('lat').value = event.latLng.lat();
	        	document.getElementById('lng').value = event.latLng.lng();
	        }
	        function addMarker(latlng,title,map) {
	        	var marker = new google.maps.Marker({
	        		position: latlng,
	        		map: map,
	        		title: title,
	        		draggable:true,
	        		icon:iconOptions
	        	});

	        	marker.addListener('drag', handleEvent);
	        	marker.addListener('dragend', handleEvent);
	        }
	        iconOptions = {
	        	path:'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
	        	scale: 1,
	        	strokeColor: 'white',
	        	strokeOpacity: 1,
	        	strokeFillColor: '#fff',
	        	strokeWeight: 1.0,
	        	fillColor:'#34495e',
	        	fillOpacity: 1
	        }
	        marker.setIcon(iconOptions);
	        marker.setMap(map);
	    }
	    google.maps.event.addDomListener(window, 'load', initialize);
	}
	/*   search map */
	if($('#map2').length){
		/*--------------- map data -----------------*/
		/*  cities   */
		// var locations;
		$.ajax({
			url: base_url+'/map/get/cities',
			type: 'GET',
			success: function( msg ) {
				if ( msg.status === 'success' ) {
					outSideMarkers(msg.data);

				}
			},
			error : function(e){
				console.log(e);
			},
		});


	 
	    /*---------map setting----------*/
	    var bounds = new google.maps.LatLngBounds();
	    /*    info window    */
	    var infowindow = new google.maps.InfoWindow();
	    /* my location */
	    function addYourLocationButton(map){
	    	var controlDiv = document.createElement('div');
	    	var firstChild = document.createElement('button');
	    	firstChild.style.backgroundColor = '#fff';
	    	firstChild.style.border = 'none';
	    	firstChild.style.outline = 'none';
	    	firstChild.style.width = '28px';
	    	firstChild.style.height = '28px';
	    	firstChild.style.borderRadius = '2px';
	    	firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
	    	firstChild.style.cursor = 'pointer';
	    	firstChild.style.marginRight = '10px';
	    	firstChild.style.padding = '0px';
	    	firstChild.title = 'Your Location';
	    	controlDiv.appendChild(firstChild);

	    	var secondChild = document.createElement('div');
	    	secondChild.style.margin = '5px';
	    	secondChild.style.width = '18px';
	    	secondChild.style.height = '18px';
	    	secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
	    	secondChild.style.backgroundSize = '180px 18px';
	    	secondChild.style.backgroundPosition = '0px 0px';
	    	secondChild.style.backgroundRepeat = 'no-repeat';
	    	secondChild.id = 'you_location_img';
	    	firstChild.appendChild(secondChild);

	    	google.maps.event.addListener(map, 'dragend', function() {
	    		$('#you_location_img').css('background-position', '0px 0px');
	    	});

	    	firstChild.addEventListener('click', function() {
	    		var imgX = '0';
	    		var animationInterval = setInterval(function(){
	    			if(imgX == '-18') imgX = '0';
	    			else imgX = '-18';
	    			$('#you_location_img').css('background-position', imgX+'px 0px');
	    		}, 500);
	    		if(navigator.geolocation) {
	    			navigator.geolocation.getCurrentPosition(function(position) {
	    				var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		                //marker.setPosition(latlng);
		                map.setCenter(latlng);
		                clearInterval(animationInterval);
		                $('#you_location_img').css('background-position', '-144px 0px');
		            });
	    		}
	    		else{
	    			clearInterval(animationInterval);
	    			$('#you_location_img').css('background-position', '0px 0px');
	    		}
	    	});

	    	controlDiv.index = 1;
	    	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
	    }
	    /*   initialize map    */
	    var map = new google.maps.Map(document.getElementById('map2'), {
	    	zoom: 10,
	    	center: new google.maps.LatLng(21, 39),
	    	mapTypeId: google.maps.MapTypeId.ROADMAP,
	    	styles:[
	    	{
	    		"elementType": "geometry",
	    		"stylers": [
	    		{
	    			"color": "#f5f5f5"
	    		}
	    		]
	    	},
	    	{
	    		"elementType": "labels.icon",
	    		"stylers": [
	    		{
	    			"visibility": "on"
	    		}
	    		]
	    	},
	    	{
	    		"elementType": "labels.text.fill",
	    		"stylers": [
	    		{
	    			"color": "#616161"
	    		}
	    		]
	    	},
	    	{
	    		"elementType": "labels.text.stroke",
	    		"stylers": [
	    		{
	    			"color": "#f5f5f5"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "administrative",
	    		"elementType": "labels.text.fill",
	    		"stylers": [
	    		{
	    			"color": "#000000"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "administrative",
	    		"elementType": "labels.text.stroke",
	    		"stylers": [
	    		{
	    			"color": "#ffffff"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "administrative.land_parcel",
	    		"elementType": "labels.text.fill",
	    		"stylers": [
	    		{
	    			"color": "#bdbdbd"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "poi",
	    		"elementType": "geometry",
	    		"stylers": [
	    		{
	    			"color": "#eeeeee"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "poi",
	    		"elementType": "labels.text.fill",
	    		"stylers": [
	    		{
	    			"color": "#757575"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "poi.park",
	    		"elementType": "geometry",
	    		"stylers": [
	    		{
	    			"color": "#d4decc"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "poi.park",
	    		"elementType": "labels.text.fill",
	    		"stylers": [
	    		{
	    			"color": "#9e9e9e"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "road",
	    		"elementType": "geometry",
	    		"stylers": [
	    		{
	    			"color": "#ffffff"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "road.arterial",
	    		"elementType": "labels.text.fill",
	    		"stylers": [
	    		{
	    			"color": "#757575"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "road.highway",
	    		"elementType": "geometry",
	    		"stylers": [
	    		{
	    			"color": "#dadada"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "road.highway",
	    		"elementType": "labels.text.fill",
	    		"stylers": [
	    		{
	    			"color": "#616161"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "road.local",
	    		"elementType": "labels.text.fill",
	    		"stylers": [
	    		{
	    			"color": "#9e9e9e"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "transit.line",
	    		"elementType": "geometry",
	    		"stylers": [
	    		{
	    			"color": "#e5e5e5"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "transit.station",
	    		"elementType": "geometry",
	    		"stylers": [
	    		{
	    			"color": "#eeeeee"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "water",
	    		"stylers": [
	    		{
	    			"visibility": "simplified"
	    		},
	    		{
	    			"weight": 0.5
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "water",
	    		"elementType": "geometry",
	    		"stylers": [
	    		{
	    			"color": "#c9c9c9"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "water",
	    		"elementType": "geometry.fill",
	    		"stylers": [
	    		{
	    			"color": "#c1d2e0"
	    		}
	    		]
	    	},
	    	{
	    		"featureType": "water",
	    		"elementType": "labels.text.fill",
	    		"stylers": [
	    		{
	    			"color": "#9e9e9e"
	    		}
	    		]
	    	}
	    	]
	    });
	    
	    addYourLocationButton(map);
	    var marker, i;
	    var markers = [];
	    /*   function to delete markers   */
	    function setMapOnAll(map) {
	    	for (var i = 0; i < markers.length; i++) {
	    		markers[i].setMap(map);
	    	}
	    }
	    function clearMarkers() {
	    	setMapOnAll(null);
	    }
	    /*   markers for inside cities   */
	    function insideMarkers(locations2){
	    	var getLocationArray = [];
	    	for (i = 0; i < locations2.length; i++) {
	    			var map_marker;
	    			console.log(locations2[i]);
	    			if (locations2[i].is_paid == 1) {

	    				map_marker = base_url+"/public/frontend/assets/imgs/bubble4.png";
	    			}else{
	    				map_marker = base_url+"/public/frontend/assets/imgs/bubble2.png";


	    			}
	    			marker = new MarkerWithLabel({
	    				position: new google.maps.LatLng(locations2[i].lat, locations2[i].lng),
	    				map: map,
	    				labelContent:locations2[i].price,
	    				labelClass:"labels",
	    				animation: google.maps.Animation.DROP,
	    				labelAnchor: new google.maps.Point(30, 0),
	    				icon:map_marker
	    			});
	    			markers.push(marker);
	    			bounds.extend(marker.position);
	    			var content = locations2[i].marker1;

	    			google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
	    				return function() {
	    					infowindow.setContent(content);
	    					infowindow.open(map,marker);

	    				$('.mapCarousel').each(function(){
							//alert('2');
							if($(this).find('.item:first-child').not('active')){
								$(this).find('.item:first-child').addClass('active');
							}
						});
	    				};
	    			})(marker,content,infowindow));  
	    	}
	    	map.fitBounds(bounds);
	    }
	    $('#property_type').on('change',function(){
			clearMarkers();
			markers = [];
			$.ajax({
				url: base_url+'/map/get/ads?name='+$('#city_name').val()+'&type='+$('option:selected', this).val(),
				type: 'GET',
				success: function( msg ) {
					if ( msg.status === 'success' ) {
						insideMarkers(msg.data);

					}
				},
				error : function(e){
					console.log(e);
				},
			});
			$('.levelUp').fadeIn(600);

			$('.level1Bubble').fadeOut(600,function(){
				$('.level2Bubble').fadeIn(600);
			});
			$('header').fadeOut(400);
			$('.fullMapCont').css('margin-top','0');
	    });
	    /*   markers for cities   */
	    function outSideMarkers(locations){

	    	for (i = 0; i < locations.length; i++) {
	    		marker = new MarkerWithLabel({
	    			position: new google.maps.LatLng(locations[i].lat,locations[i].lng),
	    			map: map,
	    			labelContent:locations[i].name,
	    			labelClass:"labels",
	    			animation: google.maps.Animation.DROP,
	    			labelAnchor: new google.maps.Point(30, 0),
	    			icon:base_url+"/public/frontend/assets/imgs/bubble2.png"
	    		});
	    		marker.set("id",locations[i].id);
	    		marker.set("name",locations[i].name);
	    		bounds.extend(marker.position);
	    		markers.push(marker);
	    		google.maps.event.addListener(marker, 'click', function() {
	    			$('#city_name').val(this.get("name"));
	    			clearMarkers();
	    			markers = [];
	    			map.panTo(this.getPosition());
	    			map.setZoom(12);
					// insideMarkers(this.get("name"));
					$.ajax({
						url: base_url+'/map/get/ads?city_id='+this.get("id"),
						type: 'GET',
						success: function( msg ) {
							if ( msg.status === 'success' ) {
								insideMarkers(msg.data);

							}
						},
						error : function(e){
							console.log(e);
						},
					});
					$('.levelUp').fadeIn(600);

					$('.level1Bubble').fadeOut(600,function(){
						$('.level2Bubble').fadeIn(600);
					});
					$('header').fadeOut(400);
					$('.fullMapCont').css('margin-top','0');
				}); 
	    	}
		    //now fit the map to the newly inclusive bounds
		    map.fitBounds(bounds);
			//restore the zoom level after the map is done scaling
			var listener = google.maps.event.addListener(map, "idle", function () {
				map.setZoom(5);
				google.maps.event.removeListener(listener);
			});
		}
		/* launch outside markers */
		// outSideMarkers();

		/*   style info window    */
		google.maps.event.addListener(infowindow, 'domready', function() {
			var iwOuter = $('.gm-style-iw');
			var iwBackground = iwOuter.prev();
			iwBackground.children(':nth-child(2)').css({'display' : 'none'});
			iwBackground.children(':nth-child(4)').css({'display' : 'none'});
			$('.gm-style-iw').each(function(){
				$(this).parent().children(":first").css('display','none');
			});
		});
		/*   level up   */
		$(document).on('click','.levelUp',function(){
			clearMarkers();
			markers = [];
			$('.levelUp').fadeOut(600);
			$.ajax({
				url: base_url+'/map/get/cities',
				type: 'GET',
				success: function( msg ) {
					if ( msg.status === 'success' ) {
						outSideMarkers(msg.data);

					}
				},
				error : function(){

		              // window.location.reload();
		          },
		      });
			// outSideMarkers();
			$('.level2Bubble').fadeOut(600,function(){
				$('.level1Bubble').fadeIn(600);
			});
			$('.fullMapCont').css('padding-top','65px');
			$('header').fadeIn(400);
		});
	}
	/*   detailsMap    */
	if($('#detailsMap').length){
		/*var ad_lng = '30.993263100000036';
		var ad_lat='30.7915709';
		var ad_city = "الرياض";
	    var ad_area="شارع الملك فهد , المنطقة الشمالية ,العزيزة , ";
	    var ad_address="عمارة 10 ,الدور الثاني ,رقم 2001";*/
	    var detailsCenter = new google.maps.LatLng(ad_lat, ad_lng);
	    function initMap() {
	    	var map = new google.maps.Map(document.getElementById('detailsMap'), {
	    		zoom: 10,
	    		center:detailsCenter,
	    		mapTypeId: google.maps.MapTypeId.ROADMAP,
	    		styles:[
	    		{
	    			"elementType": "geometry",
	    			"stylers": [
	    			{
	    				"color": "#f5f5f5"
	    			}
	    			]
	    		},
	    		{
	    			"elementType": "labels.icon",
	    			"stylers": [
	    			{
	    				"visibility": "off"
	    			}
	    			]
	    		},
	    		{
	    			"elementType": "labels.text.fill",
	    			"stylers": [
	    			{
	    				"color": "#616161"
	    			}
	    			]
	    		},
	    		{
	    			"elementType": "labels.text.stroke",
	    			"stylers": [
	    			{
	    				"color": "#f5f5f5"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "administrative.land_parcel",
	    			"elementType": "labels.text.fill",
	    			"stylers": [
	    			{
	    				"color": "#bdbdbd"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "poi",
	    			"elementType": "geometry",
	    			"stylers": [
	    			{
	    				"color": "#eeeeee"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "poi",
	    			"elementType": "labels.text.fill",
	    			"stylers": [
	    			{
	    				"color": "#757575"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "poi.park",
	    			"elementType": "geometry",
	    			"stylers": [
	    			{
	    				"color": "#e5e5e5"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "poi.park",
	    			"elementType": "labels.text.fill",
	    			"stylers": [
	    			{
	    				"color": "#9e9e9e"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "road",
	    			"elementType": "geometry",
	    			"stylers": [
	    			{
	    				"color": "#ffffff"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "road.arterial",
	    			"elementType": "labels.text.fill",
	    			"stylers": [
	    			{
	    				"color": "#757575"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "road.highway",
	    			"elementType": "geometry",
	    			"stylers": [
	    			{
	    				"color": "#dadada"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "road.highway",
	    			"elementType": "labels.text.fill",
	    			"stylers": [
	    			{
	    				"color": "#616161"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "road.local",
	    			"elementType": "labels.text.fill",
	    			"stylers": [
	    			{
	    				"color": "#9e9e9e"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "transit.line",
	    			"elementType": "geometry",
	    			"stylers": [
	    			{
	    				"color": "#e5e5e5"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "transit.station",
	    			"elementType": "geometry",
	    			"stylers": [
	    			{
	    				"color": "#eeeeee"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "water",
	    			"elementType": "geometry",
	    			"stylers": [
	    			{
	    				"color": "#c9c9c9"
	    			}
	    			]
	    		},
	    		{
	    			"featureType": "water",
	    			"elementType": "labels.text.fill",
	    			"stylers": [
	    			{
	    				"color": "#9e9e9e"
	    			}
	    			]
	    		}
	    		]
	    	});
	    	var infowindow = new google.maps.InfoWindow({
	    		content: "<div class='detailsLocate'><div class='col-sm-2 padd0'><i class='fas fa-map-marker-alt'></i></div><div class='col-sm-10 padd0'><p>"+ ad_area+" "+ ad_city+"</p><p>"+ad_address+"</p></div></div>"
	    	});
	    	infowindow.setPosition({lat:Number(ad_lat), lng: Number(ad_lng)});
	    	infowindow.open(map);
	    	google.maps.event.addListener(infowindow, 'domready', function() {
	    		var iwOuter = $('.gm-style-iw');
	    		var iwBackground = iwOuter.prev();
	    		iwBackground.css({'z-index':'2'});
	    		iwBackground.children(':nth-child(2)').css({'display' : 'none'});
	    		iwBackground.children(':last-child').css({'display' : 'none'});
	    		$('.detailsLocate').parent().css({'display':'table','width':'100%'});
	    		iwBackground.find(':nth-child(3) > div').each(function(){
	    			$(this).find('div').css({'box-shadow':'#949292 0px 1px 1px'});
	    		});
	    	});
	    }
	    google.maps.event.addDomListener(window, 'load', initMap);
	}
	/*    credit input     */
	$.fn.extend({
		credit: function ( args ) {

			$(this).each(function (){
	        	// Set defaults
	        	var defaults = {
	        		auto_select:true
	        	}
				// Init user arguments
				var args = $.extend(defaults,args);

	        	// global var for the orginal input
	        	var credit_org = $(this);

	            // Hide input if css was not set
	            credit_org.css("display","none");

	            // Create credit control holder
	            var credit_control = $('<div></div>',{
	            	class: "credit-input"
	            });

	        	// Add credit cell inputs to the holder
	        	for ( i = 0; i < 4; i++ ) {
	        		credit_control.append(
	        			$("<input />",{
	        				class: "credit-cell",
	        				placeholder: "0",
	        				maxlength: 1
	        			})
	        			);
	        	}

	        	// Print the full credit input
	        	credit_org.after( credit_control );

	        	// Global var for credit cells
	        	var cells = credit_control.children(".credit-cell");

	        	/**
				 * Set key press event for all credit inputs
				 * this function will allow only to numbers to be inserted.
				 * @access public
				 * @return {bool} check if user input is only numbers
				 */
				cells.keypress(function ( event ) {
					// Check if key code is a number
					if ( event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57) ) {
				        // Key code is a number, the `keydown` event will fire next
					    return false;
				        	
				    }
				    // Key code is not a number return false, the `keydown` event will not fire
				    return true;

				});

				/**
				 * Set key down event for all credit inputs
				 * @access public
				 * @return {void}
				 */
				cells.keydown(function ( event ) {

					// Check if key is backspace
					var backspace = ( event.keyCode == 8 );
					// Switch credit text length
					switch( $(this).val().length ) {
						case 1:
							// If key is backspace do nothing
							if ( backspace ) {
								$(this).val('');
								return;
							}
							// Select next credit element
							//alert('2');
							var n = $(this).next(".credit-cell");
							// If found
							if (n.length) {
								// Focus on it
								if( n.val().length ==0) {
									n.focus();
								}
							}
						break;
						case 0:
							// Check if key down is backspace
							if ( !backspace ) {
								// Key is not backspace, do nothing.
								return;
							}
							// Select previous credit element
							//alert('1');
							var n = $(this).prev(".credit-cell");
							// If found
							if (n.length) {
								// Focus on it
								n.focus();
							}
						break;
					}
				});

					// On cells focus
					cells.focus( function() {
					  	// Add focus class
					  	credit_control.addClass('c-focus');
					  	
							
								//alert(value);
					});

					// On focus out
					cells.blur( function() {
					  	// Remove focus class
					  	credit_control.removeClass('c-focus');
					});

					/**
					 * Update orginal input value to the credit card number
					 * @access public
					 * @return {void}
					*/
					cells.keyup(function (){
						// Init card number var
						var card_number = '';
						// For each of the credit card cells
						cells.each(function (){
							// Add current cell value
							card_number = card_number + $(this).val();
						});
						// Set orginal input value
						credit_org.val( card_number );
					});
					if ( args["auto_select"] === true ) {
						// Focus on the first credit cell input
						credit_control.children(".credit-cell:first").focus();
					}

			});
		}
	});
	$(".credit").credit();

	/*    img upload     */
	$('input[type="file"]').each(function(){
		if($(this).hasClass('uploadify')){
			//alert($(this).attr('class'));
			$(this).imageuploadify();
		}
	});
	/*   chart    */
	// if($('#chart').length){
	// 	var ctx = document.getElementById('chart').getContext('2d');
	// 	window.myLine = new Chart(ctx, config);
	// }
});
$('#forgetCarousel').bind('slid.bs.carousel', function (e) {
	if($('.credit').length){
		$(".credit-input .credit-cell:first-child").focus();
	}
});
$(document).on('click','.imageuploadify-view',function(){
	var src = $(this).parent().find('img').attr('src');
   $('#imagepreview').attr('src', src); // here asign the image to the modal when the user click the enlarge link
   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
});
/*     video upload      */
$(document).on("change", ".file_multi_video", function(evt) {
	var $source = $('#video_here');
	$source[0].src = URL.createObjectURL(this.files[0]);
	$source.parent()[0].load();
	$('.uploadV').show();
	$('#video .videoUpload').hide();
});
/*   more btn    */
$('#showMore').click(function () {
	if($('#showMore i').hasClass('fa-angle-down'))
	{
		$('#showMore').html('عرض اقل <i class="fas fa-angle-up"></i> '); 
	}
	else
	{      
		$('#showMore').html('اقرأ المزيد <i class="fas fa-angle-down"></i>'); 
	}
}); 
/* home carousel */
var a = $('#latestCarousel .latestItem');
for( var i = 0; i < a.length; i+=3 ) {
	a.slice(i, i+3).wrapAll('<div class="item"></div>');
	$('#latestCarousel .item:first-child').addClass('active');
}
/* disable select */
$(document).on('change',"#typeId select",function (e) {
   //doStuff
   var optVal= $("#typeId select option:selected").attr('id');
   if(optVal == 'rent'){
   	$('#duration').removeClass('disableInput');
   }
   else{
   	$('#duration').addClass('disableInput');
   }
});
/*  profile image   */
function readURL(input) {

	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('#profileImg').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}

$("#profileChooseImg").change(function() {
	readURL(this);
});
/* add input  */

$(document).on('click','.addInput .addNum',function(){
	var getInput ='<input class="form-control" type="text" placeholder="*****050" name="new_phones[]">';
	$(getInput).appendTo($(this).parent().parent())
	.wrap('<div class="relative form-input"></div>')
	.parent().append('<i class="orange fas fa-minus removeNum"></i>');
});
$(document).on('click','.removeNum',function(){
	$(this).parent().remove();
});
/* scroll up page */
$('.content').scroll(function() {
	scrollFunction();
});

function scrollFunction() {
	if ($('.content').scrollTop() > 20) {
		document.getElementById("up").style.display = "block";
	} else {
		document.getElementById("up").style.display = "none";
	}
}

// When the user clicks on the button, scroll to the top of the document
$(document).on('click','#up',function(){
	$('.content').animate({scrollTop:0});
});

/* scroll */
if($('.openChatBody').length){
	$('.openChatBody').niceScroll({cursorcolor:"#c7c7c7",cursorwidth:"8px",rtlmode:true, railalign:"left",cursorborder:'0'});
}
if($('.scrolledDiv').length){
	$('.scrolledDiv').niceScroll({cursorcolor:"#c7c7c7",cursorwidth:"8px",rtlmode:true, railalign:"left",cursorborder:'0'});
}
if($('.striped').length){
	$('.striped').niceScroll({cursorcolor:"#c7c7c7",cursorwidth:"8px",rtlmode:true, railalign:"left",cursorborder:'0'});
}
$('.removeNum').on('click', function(){
	phone_id = $(this).attr('data-id');
	 $.ajax({
	        url: base_url+'/user/remove/phone',
	        type: 'POST',
	        data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'phone_id' :phone_id},
	        success: function( msg ) {
	            
	    },
	    error : function(){

	    },
	  });
});
$(document).on('click','#send_msg',function(){
	msg = $('#msg').val();
	ad_owner = $('#ad_owner').val();
	  $.ajax({
	        url: base_url+'/send/message',
	        type: 'POST',
	        data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'message' :msg ,"ad_owner": ad_owner, 'msg_type': 'text'},
	        success: function( msg ) {
	            if ( msg.status === 'success' ) {
	            	$('#msg').val('');
	            	swal({
								  position: 'center',
								  type: 'success',
								  title: "تم الارسال بنجاح",
								  showConfirmButton: false,
								  timer: 2000
								});
                

	             }
	    },
	    error : function(){

	    },
	  });
});
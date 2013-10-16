// handle map

var loadMapInfoWindow;

$(document).ready(function() {
	String.prototype.pad = function(padString, length) {
		var str = this;
		while (str.length < length)
			str = padString + str;
		return str;
	}
	
	var eventDispatcher = _.clone(Backbone.Events);

	var baseUrl = $("body").attr("data-baseurl");
	var logosBaseUrl = $("body").attr("data-baseurl")+"assets/img/station_logos/";
	
	var $mapContainer = $("#page-map .map-container").first();
    var $canvas = $mapContainer.find(".map-canvas").first();
	var $infoWindowEl = $($mapContainer.find(".info-window-template").html());
	var currentInfoWindowStation = false;
    var $selectEl = $mapContainer.find(".choose-station-select").first();
    var markersData = jQuery.parseJSON($mapContainer.attr("data-markers"));
    
    var bounds = new google.maps.LatLngBounds();
	
	var pinColor = "0033CC";
    var bluePinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
		
	var pinColor = "CC0052";
    var pinkPinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
		
    var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
        new google.maps.Size(40, 37),
        new google.maps.Point(0, 0),
        new google.maps.Point(12, 35));
	
    var markers = [];
    $selectEl.append($("<option />").html("Choose...").val(""));
    for(var i=0; i<markersData.length; i++) {
        var data = markersData[i];
        var location = new google.maps.LatLng(data.lat, data.lng);
        var marker = new google.maps.Marker({
            position: location,
            title: data.name,
			icon: !data.host ? pinkPinImage : bluePinImage,
			shadow: pinShadow,
            draggable: false,
            customData: {
                id: data.id
            }
        });
        google.maps.event.addListener(marker, 'click', onMarkerClicked);
        bounds.extend(location);
        markers.push(marker);
        
        $selectEl.append($("<option />").html(data.name).val(data.id));
    }
    $selectEl.val("");
    
    var map = new google.maps.Map($canvas[0], {
        center: bounds.getCenter(),
        maxZoom: 15,
		scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.HYBRID
    });
    map.fitBounds(bounds);
    
    for(var i=0; i<markers.length; i++) {
        (function() {
            var marker = markers[i];
            setTimeout(function() {
                marker.setAnimation(google.maps.Animation.DROP);
                marker.setMap(map);
            }, i*200);
        })();
    }
    
    var infoWindow = new google.maps.InfoWindow({
        content: $infoWindowEl[0]
    });
	
	function setInfoWindowTime(time) {
		if (currentInfoWindowStation.host === false) {
			$infoWindowEl.find(".start-time").html(time.getHours().toString().pad("0", 2)+":"+time.getMinutes().toString().pad("0", 2));
		}
	}
	
	var loadInfoWindow = loadMapInfoWindow = function(id) {
        map.getStreetView().setVisible(false);
        infoWindow.close();
        var markerData;
		var markerIndex;
		for (var i=0; i<markers.length; i++) {
			if (markers[i].customData.id === id) {
				markerData = markersData[i];
				markerIndex = i;
				break;
			}
		}
        var marker = markers[markerIndex];
        infoWindow.setOptions({
            title: markerData.name
        });
		
		currentInfoWindowStation = markerData;
		
        $infoWindowEl.find(".logo").attr("src", "").width(markerData.full_logo_w).height(markerData.full_logo_h).attr("src", logosBaseUrl+"medium/"+markerData.logo_name);
	    if (!markerData.host) {
			$infoWindowEl.find(".show-if-host").hide();
			$infoWindowEl.find(".hide-if-host").show();
			var time = new Date(markerData.live_time*1000);
			setInfoWindowTime(time);
			$infoWindowEl.find(".participation-msg").html(markerData.participation_type === 0 ? "Participating LIVE!" : "Participating Via VT");
		}
		else {
			$infoWindowEl.find(".hide-if-host").hide();
			$infoWindowEl.find(".show-if-host").show();
		}
		eventDispatcher.on("timeUpdate", function(eId) {
			if (eId === id) {
				var station = _.findWhere(markersData, {id: id});
				setInfoWindowTime(new Date(station.live_time*1000));
			}
		}, this);
		infoWindow.open(map, marker);
        $selectEl.val(id);
    };
	
	eventDispatcher.on("timeUpdate", function(eId) {
		if (currentInfoWindowStation !== false && eId === currentInfoWindowStation.id) {
			setInfoWindowTime(new Date(currentInfoWindowStation.live_time*1000))
		}
	}, this);
    
    google.maps.event.addListener(infoWindow, 'domready', function() {
        $infoWindowEl.parent().css("overflow", "auto");
    });
    
    google.maps.event.addListener(map.getStreetView(), 'visible_changed', function() {
        if (map.getStreetView().getVisible()) {
            infoWindow.close();
            onInfoWindowClosed();
        }
    });
    
    google.maps.event.addListener(infoWindow,'closeclick',function() {
        onInfoWindowClosed();
    });
    
    $mapContainer.find(".reset-map-btn").click(function() {
        resetMap();
    });
    
    $selectEl.change(function() {
        if ($(this).val() == "") {
            resetMap();
        }
        else {
            loadInfoWindow(parseInt($(this).val(), 10));
        }
    });
    
    function onMarkerClicked() {
        loadInfoWindow(this.customData.id);
    }
    
    function onInfoWindowClosed() {
        $selectEl.val("");
    }
    
    
    function resetMap() {
        map.getStreetView().setVisible(false);
        infoWindow.close();
        onInfoWindowClosed();
        map.fitBounds(bounds);
    }
	
	// makes an ajax request and updates any times that have changed
	function updateLiveTimes() {
		jQuery.ajax(baseUrl+"ajax_request", {
			success: function(data) {
				_.each(data.response, function(a) {
					var station = _.findWhere(markersData, {id: a.id});
					if (station.live_time !== a.live_time) {
						station.live_time = a.live_time;
						console.log("INFO: Time updated.");
						eventDispatcher.trigger("timeUpdate", a.id);
					}
				}, this);
			},
			error: function() {
				console.log("ERROR: Error retrieving station times.");
			},
			timeout: 3000,
			dataType: "json",
			data: {
				action: "get_station_times"
			},
			type: "GET"
		});
	}
	setInterval(updateLiveTimes, 25000);
	
	initLogoBar();

});

// handle logo bar
var initLogoBar = function() {
	var $bar = $("#page-map .logo-row").first();
	
	$bar.find(".logo").each(function() {
		var $el = $(this);
			
		$(this).hover(function() {
			$el.css("z-index", 1);
		}, function() {
			$el.css("z-index", "auto");
		});
	
		$(this).click(function() {
			
			if ($el.data("aniTimer") !== undefined && $el.data("aniTimer") !== false) {
				// stop the timer that's already running
				clearTimeout($el.data("aniTimer"));
			}
			$el.removeAttr("data-clickedstate").attr("data-clickedstate", "");
			$(this).data("aniTimer", setTimeout(function() {
				$el.removeAttr("data-clickedstate");
			}, 200));
			
			loadMapInfoWindow(parseInt($el.attr("data-stationid"), 10));
			
			
		});
	});
};
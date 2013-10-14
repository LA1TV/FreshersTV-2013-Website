$(document).ready(function() {

	var logosBaseUrl = $("body").attr("data-baseurl")+"assets/img/station_logos/";
	
	var $mapContainer = $("#page-map .map-container").first();
    var $canvas = $mapContainer.find(".map-canvas").first();
	var $infoWindowEl = $($mapContainer.find(".info-window-template").html());
    var $selectEl = $mapContainer.find(".choose-station-select").first();
    var markersData = jQuery.parseJSON($mapContainer.attr("data-markers"));
    
    var bounds = new google.maps.LatLngBounds();
    var markers = [];
    $selectEl.append($("<option />").html("Choose...").val(""));
    for(var i=0; i<markersData.length; i++) {
        var data = markersData[i];
        var location = new google.maps.LatLng(data.lat, data.lng);
        var marker = new google.maps.Marker({
            position: location,
            title: data.name,
            draggable: false,
            customData: {
                index: i
            }
        });
        google.maps.event.addListener(marker, 'click', onMarkerClicked);
        bounds.extend(location);
        markers.push(marker);
        
        $selectEl.append($("<option />").html(data.name).val(i));
    }
    $selectEl.val("");
    
    var map = new google.maps.Map($canvas[0], {
        center: bounds.getCenter(),
        maxZoom: 15,
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
            loadInfoWindow($(this).val());
        }
    });
    
    function onMarkerClicked() {
        loadInfoWindow(this.customData.index);
    }
    
    function onInfoWindowClosed() {
        $selectEl.val("");
    }
    
    function loadInfoWindow(id) {
        map.getStreetView().setVisible(false);
        infoWindow.close();
        var markerData = markersData[id];
        var marker = markers[id];
        infoWindow.setOptions({
            title: markerData.name
        });
        $infoWindowEl.find(".logo").attr("src", "").width(markerData.full_logo_w).height(markerData.full_logo_h).attr("src", logosBaseUrl+"full_scaled/"+markerData.logo_name);
        $infoWindowEl.find(".start-time").html(markerData.live_time_txt);
        $infoWindowEl.find(".participation-msg").html(markerData.participation_type === 0 ? "Participating LIVE!" : "Participating Via VT");
        infoWindow.open(map, marker);
        $selectEl.val(id);
    }
    
    function resetMap() {
        map.getStreetView().setVisible(false);
        infoWindow.close();
        onInfoWindowClosed();
        map.fitBounds(bounds);
    }

});
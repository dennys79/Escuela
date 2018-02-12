var map = null;
var geocoder = null;
var center = null;
var updateX = null;
var updateY = null;
var marker = null;
var geopoints = new Array();
var addresses = new Array();

function initNXGMap(mapElement) {
    if (GBrowserIsCompatible()) {
        map = new GMap2(mapElement);
        geocoder = new GClientGeocoder();
        map.setCenter(new GLatLng(0, 0), 1);
        updateX = "coordX";
        updateY = "coordY";
        showAddresses();
        showGeopoints();
    }
}

function showAddresses() {
  for (i=0; i < addresses.length; i++) {
 	  	showAddress(addresses[i][0], addresses[i][1], addresses[i][2]);
  }	
}

function showGeopoints() {
  for (i=0; i < geopoints.length; i++) {
 	  	showGeopoint(geopoints[i][0], geopoints[i][1], geopoints[i][2], geopoints[i][3]);
  }	
}
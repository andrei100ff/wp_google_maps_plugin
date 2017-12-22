

if(php_vars.maps_zoom=='1'){
    gmapsZoom=true;
} else{
    gmapsZoom=false;
}


locations1=JSON.parse(php_vars.locat);
var locations=[];
for (i = 0; i < locations1.length; i++) {  
    locations[i]=[locations1[i][0],parseFloat(locations1[i][1]),parseFloat(locations1[i][2])];
}


      function initMap() {

        // Create a new StyledMapType object, passing it an array of styles,
        // and the name to be displayed on the map type control.
        var styledMapType = new google.maps.StyledMapType(JSON.parse(php_vars.styledmaps),
            {name: 'Styled Map'});

        // Create a map object, and include the MapTypeId to add
        // to the map type control.
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 43.654702, lng: -79.381576},
          zoom: 10,
          scrollwheel: gmapsZoom,
        disableDefaultUI: false,
          mapTypeControlOptions: {
            mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
                    'styled_map']
          }
        });
        var icon = {
            url: "assets/images/marker.png", // url
            scaledSize: new google.maps.Size(40, 64), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(20, 64) // anchor
        };
/*        var marker = new google.maps.Marker({
          position: {lat: 43.654702, lng: -79.381576},
          map: map,
          title: 'Tell Systems',
          icon: icon
        });*/

        var infowindow = new google.maps.InfoWindow();
        var bounds = new google.maps.LatLngBounds();


        var marker, i;

        for (i = 0; i < locations.length; i++) {  
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
          });

            //extend the bounds to include each marker's position
             bounds.extend(marker.position);


          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map, marker);
            }
          })(marker, i));
        }


        //now fit the map to the newly inclusive bounds
        map.fitBounds(bounds);


        //Associate the styled map with the MapTypeId and set it to display.
        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');
      }
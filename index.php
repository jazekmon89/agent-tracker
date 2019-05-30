<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
	    <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

	    <title>Agent Tracker</title>

	    <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">

        <!-- icons -->
        <link rel="stylesheet" href="css/icons.css">

        <!-- bootstrap -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-grid.css">
        <link rel="stylesheet" href="css/bootstrap-reboot.css">

        <!-- datatables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.bootstrap4.min.css">

        <!-- datepicker s-->
        <link rel="stylesheet" href="css/bootstrap-datepicker.standalone.css">

        <style type="text/css">
            /* Set a size for our map container, the Google Map will take up 100% of this container */
            #map {
                width: 100%;
                height: 400px;
            }
        </style>
	</head>
	<body>
		<div class="container">
			
		</div>

		<!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="container">
          <div class="row">


            <!-- Page Content -->
            <div id="content" class=" col-md-12 col-lg-12 col-xl-12">




              <div class="card border-0  pb-3">

                <div class="row p-3">
                  <div class="col-12">
                    <div id="map"></div>
                  </div>
                </div>

                <div class="row p-3">
                  <div class="col-6">
                    <input type="text" class="form-control" id="search-input" placeholder="Find Transaction" autocomplete="off">
                  </div>
                  <div class="col-6">
                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" id="min" class="input-sm form-control" name="start" />
                        <span class="input-group-addon">to</span>
                        <input type="text" id="max" class="input-sm form-control" name="end" />
                    </div>
                  </div>
                </div>
                <div class="row">
                	<div class="col-md-12 text-right">
                		<a class="btn btn-info btn-sm mr-3" href="#" role="button" onclick="showAllMarkersPolylines(); return false;">Reset View</a>
                	</div>
                </div>
                <div class="row">
                  <div class="col-12">
                      <table id="example" class="table table-striped nowrap" cellspacing="0" width="100%">
                        <thead class="thead-inverse">
                            <tr>
                                <th>ID</th>
                                <th>Collector</th>
                                <th>Status</th>
                                <th class="text-right">Function</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="overlay"></div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>

        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

        <!-- datatables -->
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.0/js/responsive.bootstrap4.min.js"></script>

        <!-- DatePicker -->
        <script src="js/bootstrap-datepicker.min.js"></script>

        <!-- sorting month mm/dd/yy -->
        <script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/date-uk.js"></script>

        <!-- Nice Scroll Js CDN -->
        <script src="js/jquery.nicescroll.min.js"></script>

        <!-- bootstrap -->
        <script src="js/bootstrap.js"></script>

        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        <script>
        //  dataTables
        $(document).ready(function () {
          $('.input-daterange').datepicker({
          });

          $.fn.dataTable.ext.search.push(
           function (settings, data, dataIndex) {
               var min = $('#min').datepicker("getDate");
               var max = $('#max').datepicker("getDate");
               var startDate = new Date(data[2]);
               if (min == null && max == null) { return true; }
               if (min == null && startDate <= max) { return true;}
               if(max == null && startDate >= min) {return true;}
               if (startDate <= max && startDate >= min) { return true; }
               return false;
           }
           );
          //  sorting dates
          // $.fn.dataTableExt.oSort['uk_date-pre']  = function(a) {
          //     a = a.slice(0, -2) + ' ' + a.slice(-2);
          //     var date = Date.parse(a);
          //     return typeof date === 'number' ? date : -1;
          // }
          // $.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
          //     return ((a < b) ? -1 : ((a > b) ? 1 : 0));
          // }
          // $.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
          //     return ((a < b) ? 1 : ((a > b) ? -1 : 0));
          // }

           var transactionTable = $('#example').DataTable( {
               responsive: {
                   details: {
                       display: $.fn.dataTable.Responsive.display.modal( {
                           header: function ( row ) {
                               var data = row.data();
                               return 'Details for '+data[0]+' '+data[1];
                           }
                       } ),
                       renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                           tableClass: 'table'
                       } )
                   }
               },

               columnDefs: [
                  // { "visible": false, "targets": 0 },
                  { "type": "date-uk", "targets": 2 }
              ],
              "order": [[ 0, 'desc' ]],

              // aoColumns: [
              //   { sType: 'uk_date' }
              // ],
               pageLength: 5
              // searching: false,
              // bLengthChange: false,
           } );
           window.transactionTable = transactionTable;



           $("#min").datepicker(
             {
              onSelect: function () {
                transactionTable.draw();
              },
              changeMonth: true,
              changeYear: true
            }
          );

           $("#max").datepicker(
             {
               onSelect: function () {
                 transactionTable.draw();
               },
               changeMonth: true,
               changeYear: true,
             }
           );


          //  var date = new Date(), y = date.getFullYear(), m = date.getMonth();
          //  var firstDay = new Date(y, m, 1);
          //  var lastDay = new Date(y, m + 1, 0);
           //
           //
          //  $("#min").datepicker("setDates",  new Date(firstDay));
          //  $("#max").datepicker("setDates",  new Date(lastDay));



           // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                transactionTable.draw();
            });


            $('#search-input').on( 'keyup', function () {
                transactionTable.search( this.value ).draw();
            } );
        });
        </script>


		<script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
		<!--script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyB0s52KfpuATaQcuQU3bo8Qx5M0qlzDA18&callback=initialize"></script-->
		<!--script src="https://maps.googleapis.com/maps/api/js?v=3.exp&region=GB&language=en-gb&key=AIzaSyC8wq_Z2nrMC8eVNIw2lwRS_fpqWO16-V0&libraries=poly"></script-->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&region=GB&language=en-gb&key=AIzaSyA65Vhn3B2YyJ51iXK4ekfivENc3nUzeyQ&libraries=poly"></script>
		<script>
			// Initialize Firebase
			var config = {
				apiKey: "AIzaSyCf9x_lUIusRMhIWC8NdG9pq_x3EdDAXzE",
				authDomain: "agent-tracker-be73e.firebaseapp.com",
				databaseURL: "https://agent-tracker-be73e.firebaseio.com",
				projectId: "agent-tracker-be73e",
				storageBucket: "agent-tracker-be73e.appspot.com",
				messagingSenderId: "109324020121"
			};
			var map;
    		var markers = {};
    		var static_colors = ['#4d8fac','#b5a3c4','#800080','#32cd32','#00008b','#add8e6','#ffa500','#ffcbd3','#3c00ff','#9caaf8','#2e334a','#f3123d','#766e5b'];
    		var polyline_colors = {};
    		var only_visible_agent = null;
    		var infoWindow = new google.maps.InfoWindow();
    		var default_map_position = {lat:10.3146843,lng:123.8995576}; // Cebu City
    		window.only_visible_agent = only_visible_agent;
    		var initialize = function() {
				map  = new google.maps.Map(document.getElementById('map'), {
					center:default_map_position, 
					zoom:14,
					styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]
				});
			};
			google.maps.event.addDomListener(window, 'load', initialize);
			firebase.initializeApp(config);
			function isAgentMoved(Agent, lat, long){
				var marker_tracks = markers[Agent]['tracks'];
				if(marker_tracks[marker_tracks.length-1]['lat'] != lat && marker_tracks[marker_tracks.length-1]['long'] != long)
					return true;
				return false;
			}

			function isAgentAddedNewTrack(Agent, track_count){
				return markers[Agent]['tracks'].length < track_count ? true : false;
			}

			function addMarkerEvent(marker){
				google.maps.event.addListener(marker['marker_target'], 'click', function() {
					var time_elapsed = markers[marker['agent_id']]['markers'][marker['marker_agent_infos']['index']]['time_elapsed'],
						agent_name = marker['marker_agent_infos']['agent_infos']['name'];
					infoWindow.setContent('<div class="tooltip_window"><h5 class="col-md-12 text-center">'+agent_name+'</h5><p class="col-md-12">Stay time: '+time_elapsed+' '+(parseInt(time_elapsed) > 1?'minutes':'minute')+'</p></div>')
					infoWindow.open(map, marker['marker_target']);
				});
			}

			function addMarker(Agent, lat, long, AgentInfos){
				if(!(Agent in markers)){
					markers[Agent] = {}
					markers[Agent]['tracks'] = [];
					markers[Agent]['lineCoords'] = [];
					markers[Agent]['lineCoordinatesPath'] = [];
					markers[Agent]['markers'] = [];
				}
				var counter = 0, agent_index = 0, marker, polyline, pinImage;
				for(var key in markers){
					if(key == Agent)
						break;
					counter++;
				}
				if(!(Agent in polyline_colors))
					polyline_colors[Agent] = static_colors[Object.keys(polyline_colors).length];
				pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + polyline_colors[Agent].substring(1).toUpperCase(),
				        new google.maps.Size(21, 34),
				        new google.maps.Point(0,0),
				        new google.maps.Point(10, 34));
				if(markers[Agent]['tracks'].length == 0){
					if(window.only_visible_agent != null)
						marker = new google.maps.Marker({position:{lat:lat, lng:long}, map:(window.only_visible_agent == Agent?map:null), icon:pinImage, animation:google.maps.Animation.DROP});
					else
						marker = new google.maps.Marker({position:{lat:lat, lng:long}, map:map, icon:pinImage, animation:google.maps.Animation.DROP});
					markers[Agent]['markers'].push({'time_elapsed':0, 'marker':{'agent_id':Agent, 'marker_target': marker}});
					markers[Agent]['tracks'].push({'lat':lat,'long':long}) ;
					markers[Agent]['lineCoords'].push(new google.maps.LatLng(lat, long));
					markers[Agent]['markers'][markers[Agent]['markers'].length-1]['marker']['marker_agent_infos'] = {'index':markers[Agent]['markers'].length-1, 'agent_infos': AgentInfos};
					addMarkerEvent(markers[Agent]['markers'][markers[Agent]['markers'].length-1]['marker']);
					addAgent(Agent, AgentInfos['name'], AgentInfos['status']);
				}else{
					if(isAgentMoved(Agent, lat, long)){
						if(window.only_visible_agent != null)
							marker = new google.maps.Marker({position:{lat:lat, lng:long}, map:(window.only_visible_agent == Agent?map:null), icon:pinImage, animation:google.maps.Animation.DROP});
						else
							marker = new google.maps.Marker({position:{lat:lat, lng:long}, map:map, icon:pinImage, animation:google.maps.Animation.DROP});
						markers[Agent]['markers'].push({'time_elapsed':15, 'marker':{'agent_id':Agent, 'marker_target': marker}});
						markers[Agent]['tracks'].push({'lat':lat,'long':long}) ;
						markers[Agent]['lineCoords'].push(new google.maps.LatLng(lat, long));
						polyline = new google.maps.Polyline({
							path: markers[Agent]['lineCoords'],
							geodesic: true,
							strokeColor: polyline_colors[Agent]
						});
						if(window.only_visible_agent != null)
							polyline.setMap((window.only_visible_agent == Agent?map:null));
						else
							polyline.setMap(map);
						markers[Agent]['lineCoordinatesPath'].push(polyline);
						markers[Agent]['markers'][markers[Agent]['markers'].length-1]['marker']['marker_agent_infos'] = {'index':markers[Agent]['markers'].length-1, 'agent_infos': AgentInfos};
						addMarkerEvent(markers[Agent]['markers'][markers[Agent]['markers'].length-1]['marker']);
					}else{
						markers[Agent]['tracks'].push({'lat':lat,'long':long}) ;
						/*markers[Agent]['lineCoords'].push(new google.maps.LatLng(lat, long));
						polyline = new google.maps.Polyline({
							path: markers[Agent]['lineCoords'],
							geodesic: true,
							strokeColor: static_colors[agent_index]
						});
						polyline.setMap(map);
						markers[Agent]['lineCoordinatesPath'].push(polyline);*/
						markers[Agent]['markers'][markers[Agent]['markers'].length-1]['time_elapsed'] += 15;
					}
				}
			}

			function hideAllOtherMarkersPolylines(AgentID){
				window.only_visible_agent = AgentID;
				map.setCenter(markers[AgentID]['markers'][0]['marker']['marker_target'].getPosition());
				for(agent in markers){
					if(agent != AgentID){
						for(marker in markers[agent]['markers']){
							markers[agent]['markers'][marker]['marker']['marker_target'].setMap(null);
						}
						for(polyline in markers[agent]['lineCoordinatesPath']){
							markers[agent]['lineCoordinatesPath'][polyline].setMap(null);
						}
					}else{
						for(marker in markers[agent]['markers']){
							markers[agent]['markers'][marker]['marker']['marker_target'].setMap(map);
						}
						for(polyline in markers[agent]['lineCoordinatesPath']){
							markers[agent]['lineCoordinatesPath'][polyline].setMap(map);
						}
					}
				}
			}

			function resetAll(){
				for(agent in markers){
					for(marker in markers[agent]['markers']){
						markers[agent]['markers'][marker]['marker']['marker_target'].setMap(null);
					}
					for(polyline in markers[agent]['lineCoordinatesPath']){
						markers[agent]['lineCoordinatesPath'][polyline].setMap(null);
					}
				}
				markers = {};
				window.transactionTable.clear().draw();
			}

			function showAllMarkersPolylines(){
				window.only_visible_agent = null;
				map.setCenter(default_map_position);
				for(agent in markers){
					for(marker in markers[agent]['markers']){
						markers[agent]['markers'][marker]['marker']['marker_target'].setMap(map);
					}
					for(polyline in markers[agent]['lineCoordinatesPath']){
						markers[agent]['lineCoordinatesPath'][polyline].setMap(map);
					}
				}
			}

			function addAgent(Agent, AgentName, AgentStatus){
				window.transactionTable.row.add([ Agent, AgentName, AgentStatus, '<div class="col-md-12 text-right"><a class="btn btn-info btn-sm mr-3" href="#" role="button" onclick="hideAllOtherMarkersPolylines(\''+Agent+'\'); return false;">View</a></div>']).draw();
			}
			
			var agents_tracks_all = firebase.database().ref('tracker');
			agents_tracks_all.once('value').then(function(snapshot){
				snapshot.child('agents').forEach(function(childSnapshot){
					childSnapshot.child('tracks').forEach(function(children){
						addMarker(childSnapshot.ref.getKey(), children.val().latitude,children.val().longitude, childSnapshot.child('infos').val());
					});
				});
			});
			agents_tracks_all.on('child_changed', function(snapshot) {
				if(!snapshot.val()){
					resetAll();
				}else{
					snapshot.forEach(function(childSnapshot){
						if(!(childSnapshot.ref.getKey() in markers)){
							childSnapshot.child('tracks').forEach(function(children){
								addMarker(childSnapshot.ref.getKey(), children.val().latitude,children.val().longitude, childSnapshot.child('infos').val());
							});
						}else{
							var tracks = childSnapshot.child('tracks').val();
							if(markers[childSnapshot.ref.getKey()]['tracks'].length < tracks.length)
								addMarker(childSnapshot.ref.getKey(), tracks[tracks.length-1].latitude,tracks[tracks.length-1].longitude, childSnapshot.child('infos').val());
						}
					});
				}
			});
		</script>
	</body>
</html>
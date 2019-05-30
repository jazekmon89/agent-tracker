<html>
	<head>
		<title>Agent simulator</title>
	</head>
	<body>
		<input type="button" id="start_button" value="Start">
		<input type="button" id="stop_button" value="Stop!" style="display: none">
		<br />
		<input type="button" id="reset_button" value="Reset!">
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
		<script>
			var config = {
				apiKey: "AIzaSyCf9x_lUIusRMhIWC8NdG9pq_x3EdDAXzE",
				authDomain: "agent-tracker-be73e.firebaseapp.com",
				databaseURL: "https://agent-tracker-be73e.firebaseio.com",
				projectId: "agent-tracker-be73e",
				storageBucket: "agent-tracker-be73e.appspot.com",
				messagingSenderId: "109324020121"
			};
			firebase.initializeApp(config);
			var agents_tracks_all = firebase.database().ref();
			var _timer = {};
			var counter = {};
			var agent_tracks = {
				"8974" : {
					"infos" : {
						"name" : "JK Que",
						"status" : "Active"
					},
					"tracks" : [ 
						{
							"latitude" : 10.314411,
							"longitude" : 123.914499
						}, {
							"latitude" : 10.313031,
							"longitude" : 123.915495
						}, {
							"latitude" : 10.31254,
							"longitude" : 123.91594
						}, {
							"latitude" : 10.312147,
							"longitude" : 123.916273
						}, {
							"latitude" : 10.312279,
							"longitude" : 123.916429
						}, {
							"latitude" : 10.312138,
							"longitude" : 123.916555
						}, {
							"latitude" : 10.3118213,
							"longitude" : 123.9165417
						}, {
							"latitude" : 10.311945,
							"longitude" : 123.916955
						} 
					]
				},
				"0312" : {
					"infos" : {
						"name" : "John Alfred Dalag",
						"status" : "Active"
					},
					"tracks" : [ 
						{
							"latitude" : 10.315171,
							"longitude" : 123.884399
						}, {
							"latitude" : 10.315171,
							"longitude" : 123.884399
						}, {
							"latitude" : 10.314295,
							"longitude" : 123.884142
						}, {
							"latitude" : 10.314295,
							"longitude" : 123.884142
						}, {
							"latitude" : 10.314295,
							"longitude" : 123.884142
						}, {
							"latitude" : 10.314770,
							"longitude" : 123.883209
						}, {
							"latitude" : 10.313384,
							"longitude" : 123.879898
						}, {
							"latitude" : 10.313585,
							"longitude" : 123.880202
						} 
					]
				},
				"1943" : {
					"infos" : {
						"name" : "Sean Billiones",
						"status" : "Active"
					},
					"tracks" : [ 
						{
							"latitude" : 10.310496,
							"longitude" : 123.892572
						}, {
							"latitude" : 10.309187,
							"longitude" : 123.892207
						}, {
							"latitude" : 10.308427,
							"longitude" : 123.890469
						}, {
							"latitude" : 10.309145,
							"longitude" : 123.892974
						}, {
							"latitude" : 10.307963,
							"longitude" : 123.893983
						}, {
							"latitude" : 10.307974,
							"longitude" : 123.894187
						}, {
							"latitude" : 10.307958,
							"longitude" : 123.894085
						}, {
							"latitude" : 10.308009,
							"longitude" : 123.894163
						} 
					]
				},
				"2654" : {
					"infos" : {
						"name" : "Eugene Busico",
						"status" : "Active"
					},
					"tracks" : [ 
						{
							"latitude" : 10.321330,
							"longitude" : 123.903849
						}, {
							"latitude" : 10.325805,
							"longitude" : 123.907067
						}, {
							"latitude" : 10.327002,
							"longitude" : 123.906339
						}, {
							"latitude" : 10.327614,
							"longitude" : 123.906446
						}, {
							"latitude" : 10.327783,
							"longitude" : 123.906317
						}, {
							"latitude" : 10.327509,
							"longitude" : 123.906156
						}, {
							"latitude" : 10.327192,
							"longitude" : 123.906156
						}, {
							"latitude" : 10.326654,
							"longitude" : 123.906853
						} 
					]
				},
				"2917" : {
					"infos" : {
						"name" : "Jaques Estola",
						"status" : "Active"
					},
					"tracks" : [ 
						{
							"latitude" : 10.302120,
							"longitude" : 123.900957
						}, {
							"latitude" : 10.305508,
							"longitude" : 123.900013
						}, {
							"latitude" : 10.307851,
							"longitude" : 123.899659
						}, {
							"latitude" : 10.306901,
							"longitude" : 123.896623
						}, {
							"latitude" : 10.305835,
							"longitude" : 123.894456
						}, {
							"latitude" : 10.302848,
							"longitude" : 123.895540
						}, {
							"latitude" : 10.299773,
							"longitude" : 123.897146
						}, {
							"latitude" : 10.299730,
							"longitude" : 123.897972
						} 
					]
				}
			}

			function simulate(agent_num, seconds_interval){
				_timer[agent_num] = setInterval(function(){
					if(counter[agent_num] == 0){
						var for_update = {
							"infos" : {
								"name" : agent_tracks[agent_num]['infos']['name'],
								"status" : agent_tracks[agent_num]['infos']['status']
							},
							"tracks" : [ 
								{
									"latitude" : agent_tracks[agent_num]['tracks'][counter[agent_num]]['latitude'],
									"longitude" : agent_tracks[agent_num]['tracks'][counter[agent_num]]['longitude']
								}
							]
						}
						agents_tracks_all.child('tracker').child('agents').child(agent_num).set(for_update);
					}else{
						agents_tracks_all.child('tracker').child('agents').child(agent_num).child('tracks').child(counter[agent_num]).set({latitude: agent_tracks[agent_num]['tracks'][counter[agent_num]]["latitude"], longitude: agent_tracks[agent_num]['tracks'][counter[agent_num]]["longitude"]});
					}
					counter[agent_num]++;
					if(counter[agent_num] >= agent_tracks[agent_num]['tracks'].length){
						$("#stop_button").hide();
						$("#start_button").show();
						counter[agent_num] = 0;
						clearInterval(_timer[agent_num]);
					}
				},seconds_interval);
			}

			$("#start_button").on('click', function(){
				$(this).hide();
				$("#stop_button").show();
				for(agents in agent_tracks){
					counter[agents] = 0;
					simulate(agents, (Math.floor((Math.random() * 7) + 3) * 1000));
				}
			});
			$("#stop_button").on('click', function(){
				for(agents in agent_tracks){
					if(agents in _timer)
						clearInterval(_timer[agents]);
				}
				$(this).hide();
				$("#start_button").show();
			});
			$("#reset_button").on('click', function(){
				agents_tracks_all.update({tracker: {agents: false}});
				for(agents in agent_tracks){
					counter[agents] = 0;
				}
			});
		</script>
	</body>
</html>
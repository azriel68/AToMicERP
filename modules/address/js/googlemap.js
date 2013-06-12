	
	
	//variables globales
	var ndfp_gmap_villeDepart="";
	var ndfp_gmap_villeArrivee="";
	var ndfp_gmap_distanceFinale="";
	var ndfp_gmap_urlTrajet="";
	var ndfp_gmap_distanceFinale_km="";
	
	//variables googlemap
	var map;
	var direction;

	//////////////////////////////////FONCTION GLOBALES///////////////////////////////////////////////////
	
	//fonction d'affichage du trajet entre deux villes sur la carte googlemap
	calculate = function(){
	    origin      = ndfp_gmap_villeDepart; // Le point départ
	    destination = ndfp_gmap_villeArrivee; // Le point d'arrivée
	    if(origin && destination){
		var request = {
		    origin      : origin,
		    destination : destination,
		    travelMode  : google.maps.DirectionsTravelMode.DRIVING // Mode de conduite
		}
		var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
		directionsService.route(request, function(response, status){ // Envoie de la requête pour calculer le parcours
		    if(status == google.maps.DirectionsStatus.OK){
		        direction.setDirections(response); // Trace l'itinéraire sur la carte et les différentes étapes du parcours
		        $('#ndfp_gmap_validerParcoursFinal_block').show();
		    }
		});
	    }
	};
	
	//fonction d'initialisation de la carte googlemap
	initialize = function(){
		  var latLng = new google.maps.LatLng(44.933393, 4.892360000000053); // Correspond aux coordonnées de Valence
		  var myOptions = {
			zoom      : 4, // Zoom par défaut
			center    : latLng, // Coordonnées de départ de la carte de type latLng 
			mapTypeId : google.maps.MapTypeId.TERRAIN, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
			maxZoom   : 20
		  };
		  
		  map      = new google.maps.Map(document.getElementById('map'), myOptions);
		  panel    = document.getElementById('panel');
		  
		  var marker = new google.maps.Marker({
			position : latLng,
			map      : map,
		  });
		  
		  var contentMarker = [  ].join('');

		  var infoWindow = new google.maps.InfoWindow({
			content  : contentMarker,
			position : latLng
		  });
		  
		  direction = new google.maps.DirectionsRenderer({
			map   : map
		  });

	};
			
	//fonction pour le calcul du trajet entre 2 villes (distance + affichage sur carte)	
		//fonction pour le calcul du trajet entre 2 villes (distance + affichage sur carte)	
	calculerTrajet = function(){
		
		ndfp_gmap_villeDepart=$('#depart').val();
		ndfp_gmap_villeArrivee=$('#arrivee').val();
			
			if(ndfp_gmap_villeArrivee==""||ndfp_gmap_villeDepart==""){
					$("#presCalcul").html('<h3>Veuillez saisir un parcours valide...');

			}
			else{
				//ndfp_gmap_urlTrajet = "http://maps.googleapis.com/maps/api/distancematrix/json?origins="+ndfp_gmap_villeDepart+"&destinations="+ndfp_gmap_villeArrivee+"&language=fr-FR&sensor=false";
				
					
				$.ajax({
					url: "./js/calculParcours.php?origins="+ndfp_gmap_villeDepart+"&destinations="+ndfp_gmap_villeArrivee
					,async:false
					,dataType:"json"
					,success:function(trajet) {	

							var google_status = trajet.rows[0].elements[0].status;
							

							
							if(google_status=='OK') {
								
								ndfp_gmap_distanceFinale=trajet.rows[0].elements[0].distance.value;
							
								ndfp_gmap_distanceFinale_km=(ndfp_gmap_distanceFinale/1000);
								
								ndfp_gmap_distanceFinale_km = Math.round(ndfp_gmap_distanceFinale_km*100)/100;
								
								if(!$('#allerRetour').attr('checked')){
									$("#presCalcul").html('<h3>La distance parcourue entre '+ndfp_gmap_villeDepart+' et '+ndfp_gmap_villeArrivee+' est de : '+ndfp_gmap_distanceFinale_km+'Km');
									//$('#qty').val(ndfp_gmap_distanceFinale_km);
									//$("#comment").val('La distance parcourue entre '+ndfp_gmap_villeDepart+' et '+ndfp_gmap_villeArrivee+' est de : '+ndfp_gmap_distanceFinale_km+'Km')
								}
								else{
									ndfp_gmap_distanceFinale_km*=2;
									$("#presCalcul").html('<h3>La distance Aller-Retour parcourue entre '+ndfp_gmap_villeDepart+' et '+ndfp_gmap_villeArrivee+' est de : '+ndfp_gmap_distanceFinale_km+'Km');
									//$('#qty').val(ndfp_gmap_distanceFinale_km);
								}
							}
															
								
							
							else if(google_status=="NOT_FOUND"){
								$("#presCalcul").html("<h3>Impossible de trouver l'adresse de départ ou d'arrivée.");
							}
							else if(google_status=="ZERO_RESULTS"){
								$("#presCalcul").html("<h3>Impossible de calculer l'itinéraire. Veuillez être plus précis.");
							}
							else{
								$("#presCalcul").html("<h3>Une erreur s'est produite.");

							}
					}
							
				});
					
				calculate();
			}
	}
	
	enregistrerTrajet = function(){
		if(ndfp_gmap_distanceFinale_km){
			$('#qty').val(ndfp_gmap_distanceFinale_km).trigger("keydown");
			$("#comment").val('Trajet entre '+ndfp_gmap_villeDepart+' et '+ndfp_gmap_villeArrivee+' : '+ndfp_gmap_distanceFinale_km+'Km')
			$('#popupCalculFraisKilometrique').dialog('close');
			computeTTC(ndfp_gmap_distanceFinale_km);
			changeTTC(null);
		}else {
			$("#presCalcul").html('<h1>Veuillez saisir un parcours valide...');
		}
	}
	

	////////////////////////////////// FIN FONCTION GLOBALES///////////////////////////////////////////////////


	/////////////////////////////////////GESTION DU DOCUMENT\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	
	$(document).ready( function(){
		
		
		$('#popupCalculFraisKilometrique').dialog({
			title:"Veuillez renseigner votre parcours"
			,autoOpen:false
			,width:'450px'
			,modal:true
			
		});
		
		$('a.popGoogleMap').click(function(){
			initialize();
			calculate();
			$('#popupCalculFraisKilometrique').dialog('open');
			initialize();
			calculate();
			
		});
		
		
		//clic sur Valider de la pop-in
	  	 $('#popupCalculFraisKilometrique #ndfp_gmap_validerParcours').click( 	function(){
			calculerTrajet();
	    });
	    
	    $('#popupCalculFraisKilometrique #allerRetour').click( 	function(){
			calculerTrajet();
	    });		
	    
	    $('#popupCalculFraisKilometrique #ndfp_gmap_validerParcoursFinal').click( function(){
			enregistrerTrajet();
			
	    });	
	    
	    //au moment où l'on choisit le type de frais (exemple: 6 => frais kilométriques)
	    $('#fk_exp').change( 	function(){  
	/*
			var indexSelect = $("select[name='fk_exp'] option:selected").val();
			
			if(indexSelect==6){
				//$('#calculKm').show();
				$('a.popGoogleMap').show();
				$("#lol").html('lol'+$("select[name='fk_exp'] option:selected").text()+'lol');
				$('#qty').css("background-color", "#D4DBDE");
			}*/
			var indexSelect = $('#hiddenKm').val();
			if(indexSelect==$("select[name='fk_exp'] option:selected").val()){
				//$('#calculKm').show();
				$('a.popGoogleMap').show();
				if(droitWriteQtyKM==0) $('#qty').css("background-color", "#D4DBDE");
			}
			else {
				//$('#calculKm').hide();
				$('a.popGoogleMap').hide();
				if(droitWriteQtyKM==0) $('#qty').css("background-color", "#fff");
			}
						
		});
		
		//appui sur entree dans la pop-in pour calculer le parcours 
	   $('#popupCalculFraisKilometrique').keypress(function(e) {
				$('#unelettre').text(e.which);  //keyCode
				switch(e.which){
					case 13 : 
						calculerTrajet();
					break;
				}
		});
	
});
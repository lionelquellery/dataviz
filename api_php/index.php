<?php

// Exemple d'utilisation de Flight PHP

header('Content-type: application/json'); // on définit la page comme json

require 'flight/Flight.php'; // on intégre la librairie flight


$key = '?key=4a54b75d241c';


Flight::route('GET /search/@id', function($id){

	global $key;
	$key_series = $id;
	//  NOMBRE DE SAISON

	function get_curl_request($url){

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://api.betaseries.com/".$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Accept: application/json"
		));

		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
	$answer = get_curl_request("shows/display".$key."&id=".$key_series);
	$serie  = json_decode($answer);

	//Nombre de saisons	
	$seasons_number = $serie->show->seasons;

	//Episodes numbers
	$episodes_numbers = $serie->show->episodes;

	//Init serie data
	$saison_data = array();

	$answer   = get_curl_request("shows/episodes".$key."&id=".$key_series);
	$episodes = json_decode($answer);
	$episodes_notes = array();

	foreach($episodes->episodes as $episode){
		
		$episodes_notes[] = $episode->note->mean;
		
	}

	$count = 0;
	
	for($i = 0; $i < $seasons_number; $i++){
			
		$slice = array_slice($episodes_notes, $count, $serie->show->seasons_details[$i]->episodes);
		$saison_data[] = $slice;
		
		$count = $count + $serie->show->seasons_details[$i]->episodes;

	}

	echo json_encode($saison_data, JSON_PRETTY_PRINT);  // json pretty print permet d'indenter ton resultat         

});


// On oubli pas d'initialiser flight une fois les routes definit
Flight::start();

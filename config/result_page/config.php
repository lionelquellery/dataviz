<?php

$key = '?key=4a54b75d241c';
$key_series = $_GET['id'];

// Fonction de la requete curl

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

function get_picture($id){
		
	$key = '?key=4a54b75d241c';
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://api.betaseries.com/shows/pictures".$key."&id=".$id);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Accept: application/json"
	));

	$response = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($response);
	return $data->pictures[0]->url;
	
}
// Requete personnages
$answer = get_curl_request("shows/characters".$key."&id=".$key_series);
$characters = json_decode($answer);

//Requete general
$answer = get_curl_request("shows/display".$key."&id=".$key_series);
$data = json_decode($answer);

//  Description
$description = $data->show->description;

//Nombre de saisons
$seasons_number   = $data->show->seasons;

//Episodes numbers
$episodes_numbers = $data->show->episodes;

// Serie similaire
$similar = $data->show->similars;

//No graph
$error = 'The first season of your series is still ongoing. Therefore no data are available.';

$serie_overview = $description . "<br><a href=".$data->show->resource_url." target='_blank'>See more on Betaseries</a>";
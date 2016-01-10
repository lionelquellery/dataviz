<?php

// Clef d'accès au API
$key = '?key=4a54b75d241c';
// Curl accès aux Infos de la séries
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
// Conversion de Json en PHP
$answer = get_curl_request("shows/list".$key."&limit=20&order=popularity");
$data = json_decode($answer); 

// Fonction de cherche

if(!empty($_POST['search'])){
	//chaine de caractère de l'utilisateur
	$research = $_POST['search'];

	$answer = get_curl_request("shows/search".$key."&title=".$research);
	$search = json_decode($answer);
}

//Fonction accès images du show
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
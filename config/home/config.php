<?php

// Clef d'accès au API
$key = '?api_key=d0a923b609a899bbb5a493dc98fe31bd';
// Curl accès aux Infos de la séries
function get_curl_request($url){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://api.themoviedb.org/3/".$url);
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
$answer = get_curl_request("tv/popular".$key);
$data = json_decode($answer); 

// Fonction de cherche

if(!empty($_POST['search'])){
    $key_search = '&api_key=d0a923b609a899bbb5a493dc98fe31bd';
    //chaine de caractère de l'utilisateur
    $research = $_POST['search'];
    
$answer = get_curl_request("search/tv?query=".$research.$key_search);
$search = json_decode($answer);
}

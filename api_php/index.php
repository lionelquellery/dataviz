<?php

// Exemple d'utilisation de Flight PHP

header('Content-type: application/json'); // on définit la page comme json

require 'flight/Flight.php'; // on intégre la librairie flight


$key = '?api_key=d0a923b609a899bbb5a493dc98fe31bd';


Flight::route('GET /search/@id', function($id){

    global $key;
    $key_series = $id;
//  NOMBRE DE SAISON

function get_curl_request($url){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://api.themoviedb.org/3/tv/".$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
//  NOMBRE D'EPISODE PAR SAISON

$answer = get_curl_request($key_series.$key);
$serie = json_decode($answer);
$counter = $serie->seasons;

//  NOMBRE DE SAISON

$answer = get_curl_request($key_series."/changes".$key);
$number_saison = json_decode($answer);


$saison_data = array();
$ct = 0;
$compteur_input = 0;

foreach($counter as $_episodes): 
    $ct = $ct+1;
    $episode =$ct-1;
    $saison_data += array($_episodes->season_number => array());
endforeach;

for($x=0; $x < $ct ; $x++){

    $answer = get_curl_request($key_series."/season/".$x.$key);
    $average_seasons = json_decode($answer);
    $compteur=0;
                    
    if(empty($average_seasons->episodes))
    {
        $error = 'Votre série n\'a qu\'une saison et elle n\'est pas finit. Aucune donnée n\'est donc disponible.';
    }
    else
    {
        foreach($average_seasons->episodes as $episode_average):
            $compteur = $compteur + 1;
            $fill = $episode_average->vote_average;
            $saison_data[$x] += array_fill(0, $compteur, $fill);
        endforeach;
    }
}
  
echo json_encode($saison_data, JSON_PRETTY_PRINT);  // json pretty print permet d'indenter ton resultat         

});


// On oubli pas d'initialiser flight une fois les routes definit
Flight::start();

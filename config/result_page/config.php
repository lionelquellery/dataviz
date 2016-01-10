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
// Requete personnages
$answer = get_curl_request("shows/characters".$key."&id=".$key_series);
$characters = json_decode($answer);

//Requete general
$answer = get_curl_request("shows/display".$key."&id=".$key_series);
$serie = json_decode($answer);

//  Description
$serie_lenght = strlen($serie->show->description);

//Nombre de saisons
$counter = $serie->show->seasons;

// Serie similaire
$similar = $serie->show->similars;


$saison_data = array();
$ct = 0;
$compteur_input = 0;
$error = 'The first season of your series is still ongoing. Therefore no data are available.';


foreach($counter as $_episodes): 
$ct = $ct+1;
$episode =$ct-1;
$saison_data += array($_episodes->season_number => array());
endforeach;


for($x=0; $x < $ct ; $x++){

    $answer = get_curl_request($key_series."/season/".$x.$key);
    $average_seasons = json_decode($answer);
    $compteur=0;

}

if(!empty($average_seasons->episodes)){
    if(!empty($serie->homepage)){
        if($serie_lenght > 300){
            $serie_overview = substr($serie->overview,0,300)."... <a href=".$serie->homepage." target='_blank'> See more</a>";
        }
        else{
            $serie_overview = $serie->overview."<a href=".$serie->homepage." target='_blank'> See more</a>";
        }
    }
    else{
        if($serie_lenght > 300){
            $serie_overview = substr($serie->overview,0,300);
        }
        else{
            $serie_overview = $serie->overview;
        }
    }
}
else{
    if(!empty($serie->homepage)){
        $serie_overview = $serie->overview."<a href=".$serie->homepage." target='_blank'> See more</a>";
    }
    else{
        $serie_overview = $serie->overview;
    } 
}

var_dump($saison_data);
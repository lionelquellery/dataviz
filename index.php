<?php

require ('config/home/config.php');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>DATASERIES</title>
        <link rel="stylesheet" type="text/css" href="ressources/css/reset.css">
        <link rel="stylesheet" type="text/css" href="ressources/css/home/home.css">
        <link href='http://fonts.googleapis.com/css?family=Raleway:700,900,400,200' rel='stylesheet' type='text/css'>
        <link rel="icon" type="image/png" href="ressources/img/favicon-Data-Series.ico" />
    </head>
    <body>
        <section>
            <?php if(!empty($_POST['search'])){?>
            <div class="suggest"  id="hideme">
                <a href="#" onClick="hide('hideme')" class="close">CLOSE ×</a>

                <?php if($search->total_results == 0){ ?>
                <div class='sorry'>
                    Oops, no TV show matches your search...
                </div>
                <?php } else{?>

                <div class='success'>
                    <div class='upperline'></div>
                    <h2>You're maybe looking for :</h2>


                    <?php foreach($search->results as $_result):?>
                    <a href="result.php?id=<?= $_result->id?>">
                        <span class='img'>
                            <?php if(!empty($_result->backdrop_path)){ ?>
                            <img src="http://image.tmdb.org/t/p/w75<?= $_result->backdrop_path?>" alt="">
                            <?php }
                             else{ ?>
                            <img src="ressources/img/nonDispoSmall.svg" alt="">
                            <?php } ?>
                        </span>
                        <span>
                            <?= $_result->original_name ?>
                        </span>
                    </a>
                    <br>
                    <?php endforeach; 
                            }?>
                </div>
            </div>
            <?php } ?>

            <img class="logo" src="ressources/img/logo.svg" alt="">    
            <form action="#" method="post">
                <input type="search" class="inputstyle" placeholder="Find your favourite TV Show" name="search">
                <input type="submit" value="">    
            </form> 


        </section>
        <div class="container">
            <div class="line"></div>
            <p class="popular">Most popular TV shows :</p>
            <?php for($i = 0; $i < 19; $i++){?>    
            <div class="media" data-sr="enter top, ease down 20%">
               <?php if(empty($data->results[$i]->backdrop_path)){ ?> 
                   <img src="ressources/img/nonDispoSmall.svg" alt="">
                <?php }
                else{ ?>
                    <img class="media__image" src="http://image.tmdb.org/t/p/w600<?= $data->results[$i]->backdrop_path?>" alt="" />
                <?php } ?>
                <a href="result.php?id=<?= $data->results[$i]->id ?>">
                    <div class="media__body">
                        <h2><?= $data->results[$i]->original_name?></h2>
                    </div>
                </a>
            </div>

            <?php } ?>
        </div>
        <div class="reference">
            Our services use the ThemovieDB api
        </div>
        

        <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src='ressources/js/min/scrollReveal.min.js'></script>
        <script src="ressources/js/app.js"></script>
    </body>
</html>
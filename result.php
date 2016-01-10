<?php

require('config/result_page/config.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $serie->name ?></title>
        <meta description="">
        <meta name="viewport" content="initial-scale=0.2">
        <meta name="viewport" content="width=device-width,user-scalable=no">
        <link rel="stylesheet" href="ressources/css/reset.css">
        <link rel="stylesheet" href="ressources/css/result/style.css">
        <link rel="stylesheet" href="ressources/font/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="ressources/css/loader.css">
        <link rel="stylesheet" href="ressources/css/result/index.css">
        <link rel="icon" type="image/png" href="ressources/img/favicon-Data-Series.ico" />


    </head>
    <body>
        <!--loader-->
        <div id="overlay">
            <div class="overlay-inner coffee"></div>
        </div>


        <div class="main">
            <!--	logo        -->
            <section class="left">
                <header>
                    <a href="index.php"><div class="logo">Data<span class="logo-bold">Series</span></div></a>
                </header>
                
                <div class="popularity actual transition_lente">
                   <div class="clear"></div>
                    <!--			info de la serie    -->
                    <h1><?= $data->show->title ?></h1>
                    <p class="note">TV Show's note :   <?= $data->show->notes->mean ?> / 10</p>
                    <p class="synopsis"><?= $serie_overview ?>
                    <h2>Popularity over the time</h2>    
                    <nav>

                        <!--				generation du canvas      -->
                        <?php if($seasons_number == 0 ){ ?>
                            <div class="no_canvas"><?= $error ?></div>
                        <?php }
                        else { ?>
                            <ul class="seasons">
                                <li>
                                    <input type="button" name="0" value="Serie" class="seasons active first">
                                </li>
                                <?php for($i=1; $i < $seasons_number+1; $i++ ){ ?> 
                                    <li>
                                        <input type="button" name="<?= $i ?>" value="Season <?= $i ?>" class="seasons">
                                    </li>
                                <?php } ?>
                            </ul>

                    </nav>
                    <div class="coord-system">
                        <div class="coord-line coord-line-height"></div>
                        <div class="coord-line coord-line-width"></div>
                        <div class="wrapper-arrow">
                            <div class="coord-line coord-line-rotate-left rotate-left-45 arrow-line-left"></div>
                            <div class="coord-line coord-line-rotate-right rotate-right-45 arrow-line-right"></div>
                        </div>
                        <div class="wrapper-arrow-2">
                            <div class="coord-line coord-line-rotate-left rotate-left-45 arrow-line-left"></div>
                            <div class="coord-line coord-line-rotate-right rotate-right-45 arrow-line-right"></div>
                        </div>
                        <p class="txt-legend txt-grade">GRADE</p>
                        <p class="txt-legend txt-episode-season">SEASON</p>
                        <div class="seriecanvas_wrp">
                            <canvas id="seriecanvas" width="620" height="380"></canvas>
                        </div>
                    </div>
                    <?php } ?>

                    <!--Bouton next-->
                    <div class="next">
                        <i class="fa fa-angle-down"></i>
                    </div>
                </div>

                <div class="characters waiting transition_lente">
                    <div class="prec">
                        <i class="fa fa-angle-up"></i>
                    </div>

                    <!--        Generation chaque personnages série + image de l'acteur-->
                    <h2>Casting</h2>
                    <?php for($c=0; $c<8; $c++){ ?>
                    <!--           image      -->
                    <div class="col-half">
                        <?php if(empty($characters->characters[$c]->picture)){ ?>
                            <div class="radius-img"></div>
                        <?php }
                        else{ ?>
                            <div style="background-image:url(<?= $characters->characters[$c]->picture ?>)" class="radius-img"></div>
                        <?php } ?>
                        <!--        nom du personnage joué   --> 
                        <?php if(empty($characters->characters[$c]->actor)){ ?>           
                            <p class="charactername">
                            </p>
                        <?php }
                        else{ ?>
                            <p class="charactername">
                                <?= $characters->characters[$c]->actor?>
                            </p>
                        <?php } ?>
                        <!--        nom de l'acteur   -->
                        <?php if(empty($characters->characters[$c]->name)){ ?>   
                             <p class="actorname">
                            </p>
                        <?php }
                        else{ ?>
                            <p class="actorname">
                                <span class="as">As </span><?= $characters->characters[$c]->name ?>
                            </p>
                        <?php } ?>
                    </div>
                    <?php } ?>

                    <div class="next2">
                        <i class="fa fa-angle-down"></i>
                    </div>

                </div>

                <div class="Lionel waiting transition_lente">
                    <div class="prec2">
                        <i class="fa fa-angle-up"></i>
                    </div >

                          <div class="dates">
                           
                            <div class="timestamp first_graph">
                                <div class="episode">First air date</div>
                                <div class="date"><?= $data->show->creation ?></div>
                                <div class="point"></div>
                            </div>
                            
                            <div class="timestamp last">
                                <div class="episode">Last air date</div>
                                <div class="date"><?= "pas de date" ?></div>
                                <div class="point"></div>
                            </div>
                        
                          </div>
                          <div class="status"></div>

                      
                    <div class="bulle">
                       <div class="counter">
                           <div class="count_left count transition">
                               <input type="hidden" name="<?= $episodes_numbers ?>">
                           </div>
                           Number of episodes
                       </div>
                       <div class="counter">   
                           <div class="count_right count transition">
                               <input type="hidden" name="<?= $seasons_number ?>">
                           </div>
                           Number of seasons
                       </div>
                     </div>
                </div>

            </section>  
        </div>     

        <!--	    image de droite -->

        <?php if(empty(get_picture($data->show->id))){ ?>
            <div class="right" style="background-image:url(ressources/img/nonDispobig.svg)">
        <?php }
        else{ ?>
            <div class="right" style="background-image:url(<?php echo get_picture($data->show->id) ?>)">
        <?php }?>
            </div>


            <!--          suggestions autre series   -->
            <?php if(!empty($data->show->similars)){ ?>
            <div class="white-block">
                <i class="fa fa-angle-right"></i>
                <a href="result.php?id=<?= $data->show->similars ?>">
                    <span class="suggestion">
                        <img src="<?= get_picture($data->show->similars) ?>" alt="">
                    </span>
                </a>
            </div>
            <?php }?>
        </div>

        <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="ressources/js/serie.js"></script>
        <script src="ressources/js/lionel.loader.js"></script>
        <script>
            getData(<?=$_GET['id']?>)
        </script>

    </body>
</html>
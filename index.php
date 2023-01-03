b<?php //header('Content-Type: application/json');

$jsonurl = "https://esn.paris/facebook-events/json_fb_events.json";
$json = file_get_contents($jsonurl);
$obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);



?>
    <link href="css/style.css" rel="stylesheet">
    <div class="container">
        <div class="page-header">
                <?php
                // count the number of events
                $event_count = count($obj['data']);
                $inputCarrousel = "";
                $carrouselSlide = "";
                $carrousel_thumbnails = "";
         
                for($x=$event_count-1; $x>=$event_count-15; $x--){
                    $compteur= $x + 1;
                                    // set timezone
                    date_default_timezone_set($obj['data'][$x]['timezone']);
                    setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
            
                    $start_date = [];
                    // Si l'evenement n'est pas multiple
                    if (!isset($obj['data'][$x]['event_times'])){
                        // Avec utf8_encore, il y a un probleme avec û qui n'est pas compris. Donc str_replace
                        $dateAvecPloblemeU = ucfirst(utf8_encode(strftime("%A %d %B a %Hh%M",strtotime($obj['data'][$x]['start_time']))));
                        $start_date[] = str_replace("Ã»","û",$dateAvecPloblemeU);
                    }else{ // Si l'evenement est multiple
                        
                        // Tout les autres events
                        $reverseDateArray = array_reverse($obj['data'][$x]['event_times']);
                        foreach($reverseDateArray as $event_time){
                            $dateAvecPloblemeU = ucfirst(utf8_encode(strftime("%A %d %B a %Hh%M",strtotime($event_time["start_time"]))));
                            $start_date[] = str_replace("Ã»","û",$dateAvecPloblemeU);
                            
                        }
                        
                    }

                    $str_date = implode("<br> ", $start_date);
        
                    $image = isset($obj['data'][$x]['cover']['source']) ? $obj['data'][$x]['cover']['source'] : "https://graph.facebook.com/v11.0/{$fb_page_id}/picture?type=large";
                    
                    $eid = $obj['data'][$x]['id'];
                    $name = ucfirst($obj['data'][$x]['name']);
                    $description = isset($obj['data'][$x]['description']) ? $obj['data'][$x]['description'] : "";
                    $description_courte = substr($description,0,250);
                    
                    
                    // place
                    $place_name = isset($obj['data'][$x]['place']['name']) ? $obj['data'][$x]['place']['name'] : "";
                    $city = isset($obj['data'][$x]['place']['location']['city']) ? $obj['data'][$x]['place']['location']['city'] : "";
                    $country = isset($obj['data'][$x]['place']['location']['country']) ? $obj['data'][$x]['place']['location']['country'] : "";
                    $zip = isset($obj['data'][$x]['place']['location']['zip']) ? $obj['data'][$x]['place']['location']['zip'] : "";
                    
                    $location="";
                    
                    if($place_name && $city && $country && $zip){
                        $location="{$place_name}, {$city}, {$country}, {$zip}";
                    }else{
                        $location="Pas de lieux précisé";
                    }

                    $lienBillet = isset($obj['data'][$x]['ticket_uri']) ? $obj['data'][$x]['ticket_uri'] : "";
                    
                    $billet = isset($obj['data'][$x]['ticket_uri']) ? "<a href=\"$lienBillet\" target=\"_blank\" >Cliquez ici pour obtenir les billets</a>" : "Pas de billets necessaire";

                    // Si le billet existe
                    if (isset($obj['data'][$x]['ticket_uri'])){
                        $lienImage = $lienBillet;
                    }else{
                        $lienImage = "#";
                    }
                    
                    // Lien vers les events https://www.facebook.com/events/{$eid}/
                    // mettre une image <img src='{$image}' width='200px'

                    $inputCarrousel .= "<input type=\"radio\" name=\"slides\" id=\"slide-$compteur\">";
                  
                    $carrouselSlide .="<li class=\"carousel__slide\">
                    <h3>$name</h3>
                    <figure>
                        <a href=\"$lienImage\">
                            <img src=\"$image\" alt=\"\">
                        </a>
                        <figcaption>
                            <p><strong>Date</strong> : $str_date</p>
                            <p><strong>Lieux</strong> : $location</p>
                            <p><a href=\"#popup-description-$eid\"><strong>Description</strong> : $description_courte...</a></p>
                            <p><strong>Billets</strong> : $billet</p>
                            
                        </figcaption>
                    </figure>
                    </li>";

                    $carrousel_thumbnails .= "<li>
                    <label for=\"slide-$compteur\"><img src=\"$image\" alt=\"Image evenement ESN $name\"></label>
                </li>"; 
                    ?>
                    <div id="popup-description-<?=$eid?>" class="overlay">
                        <div class="popup">
                            <h2>Description</h2>
                            <a class="close" href="#">&times;</a>
                            <div href="#" class="content">
                                <a class="content" href="#">
                                    <?= $description . " - " . $name?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php

   

                }?>
        </div>
        <section class="diapo-fb" id="nos-events">
            <div class="container">
                <div class="carousel">
                    <!-- Tout les inputs viennent de la boucle -->
                    <?= $inputCarrousel; ?>
                    <ul class="carousel__slides">
                        <?= $carrouselSlide; ?>
                    </ul>
                       
                    <ul class="carousel__thumbnails">
                        <?= $carrousel_thumbnails; ?>
                    </ul>
                </div>
            </div>
        </section>
    </div>


    
  
</html>
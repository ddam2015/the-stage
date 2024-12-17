<?php
/**
 * Template Name: Gold Teams
 */

get_header();
$award_id = $wp_query->query_vars['aw_id'];
$tournament_awards = g365_fn(['fn_name'=>'g365_remote_tournament_award', 'arguments'=>[['award_id'=>$award_id], 'null']]);
$tournament_awards = json_decode(json_encode($tournament_awards), true); 
// echo "<pre>"; print_r($tournament_awards['award_options']['records']); echo "</pre>"; test test


$gold_teams_images = array(   "Dynasty" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/Team-Dynasty-Elite_400x300.png",  "Gamepoint Basketball" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/gamepoint-1.png",   "Future Elite" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/Future_Elite.png",   "Hoop Nation" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/hoop-nation-2.png",   "Lakeshow" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/LakeShow-1.png",   "Az Storm" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/AZ-STORM-new-1.png",   "San Diego Allstars" => "https://thestagecircuit.com/wp-content/uploads/2024/01/SDA400x300.png",   "Northwest Greyhounds" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/nw-greyhounds_6510-2.png",   "SUSA" => "https://thestagecircuit.com/wp-content/uploads/2024/01/SUSAHoops400x300.png",   "Arizona Prime" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/prime_basketball_az.png",   "AK Rivals" => "https://thestagecircuit.com/wp-content/uploads/2024/02/AKRivals400x300.png",   "San Francisco Rebels" => "https://thestagecircuit.com/wp-content/uploads/2024/01/SFRebels400x300.png",   "Phoenix Runnin’ Rebels" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/RunninRebels.png",   "Team Zona" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/zona-1.png",   "Meta Hoops" => "https://thestagecircuit.com/wp-content/uploads/2024/01/MetaHoops400x300.png",  "Coastal Elite" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/Coastal-Elite.png",   "PHPS" => "https://thestagecircuit.com/wp-content/uploads/2024/01/PlayHardPlaySmart400x300.png",   "Bay City Warriors" => "https://thestagecircuit.com/wp-content/uploads/2024/01/BayCityWarriors400x300.png",   "Swoosh Elite" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/Swoosh-Elite.png",   "SacTown Pharaohs" => "https://thestagecircuit.com/wp-content/uploads/2024/01/sactownpharaohs400x300.png",   "NorCal Prep" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/norcal-prep-basketball_2086.png",   "Project excellence" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/project-excellence-1.png",   "I Can Allstars" => "https://thestagecircuit.com/wp-content/uploads/2024/01/ICAN400x300.png",   "Beauchamp Elite" => "https://thestagecircuit.com/wp-content/uploads/2024/01/BeauchampElite400x300.png",   "Team Nation Red" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/Team-Nation.png",   "The Right Way Academy Miners" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/TheRightWay.png",   "Rize Elite" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/RizeElite.png",   "CT Northstars Elite" => "https://thestagecircuit.com/wp-content/uploads/2024/01/CTNorthstars400x300.png",   "Localhoops Training Academy" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/Local-Hoops_400x300-1.png",   "Utah Hard Knox" => "https://thestagecircuit.com/wp-content/uploads/2024/01/utahhardknox400x300.png",   "West Coast Finest" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/West-Coast-Finest.png",   "SF Work Hard Play Hard" => "https://thestagecircuit.com/wp-content/uploads/2024/01/SFWorkHardPlayHard400x300.png",   "FLASH! ELITE" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/Flash_Elite.png",   "AZ Grassroots" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/AZ-Grassrroots.png",   "Evolve Performance" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/Evolve-Performance.png",   "OGP Anaheim" => "https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/OGP-Anaheim.png", "OGP Ladera" => "https://opengympremier.com/wp-content/uploads/2022/08/OGP-Ladera-400x300-1.png", "Team Norcal" => "https://thestagecircuit.com/wp-content/uploads/2024/02/TeamNorCal400x300.png", "Prolific Sports Club" => "https://thestagecircuit.com/wp-content/uploads/2024/01/ProlificSportClub400x300.png", "E.A. Prep Stars" => "https://thestagecircuit.com/wp-content/uploads/2024/01/EAPrepStars400x300.png", "Sacramento Renegades" => "https://thestagecircuit.com/wp-content/uploads/2024/01/SacRenegades400x300.png", "Utah Valley Prime" => "https://thestagecircuit.com/wp-content/uploads/2024/01/UtahValleyPrime400x300.png", "Control Chaos" => "https://thestagecircuit.com/wp-content/uploads/2024/01/ControlChaos400x300.png", "LA Select" => "https://thestagecircuit.com/wp-content/uploads/2024/01/LASelect400x300.png", "Wolf Pack Training D1" => "https://thestagecircuit.com/wp-content/uploads/2024/01/WolfPackTrainingD1400x300.png", "Colorado Magic" => "https://thestagecircuit.com/wp-content/uploads/2024/01/COMagic400x300.png", "YBA Aftermath" => "https://thestagecircuit.com/wp-content/uploads/2024/01/YBAAftermath400x300.png", "West Coast Flight" => "https://thestagecircuit.com/wp-content/uploads/2024/01/WCFlight400x300.png", "Team Esface Basketball Academy" => "https://thestagecircuit.com/wp-content/uploads/2024/01/TEAM-ESFACE400x300.png", "NW Drip" => "https://thestagecircuit.com/wp-content/uploads/2024/01/NWDrip400x300.png", "Team California" => "https://thestagecircuit.com/wp-content/uploads/2024/01/TeamCalifornia400x300.png", "We Rise Elite" => "https://thestagecircuit.com/wp-content/uploads/2024/03/werise.png", "UBC Elite" => "https://thestagecircuit.com/wp-content/uploads/2024/01/UBCElite400x300.png", "California Select/Sixth Man" => "https://strictlyhoopsbasketball.com/wp-content/uploads/2024/01/Sixth-Man-Instagram-Profile-Pic-Anthony-Bradley.jpg", "IE Fire" => "https://thestagecircuit.com/wp-content/uploads/2024/01/IE-FIRE400x300.png", "Wildcats Elite" => "https://thestagecircuit.com/wp-content/uploads/2024/01/WildcatsElite400x300.png", "Evolution Basketball" => "https://thestagecircuit.com/wp-content/uploads/2024/01/EvolutionBBall400x300.png", "DNA Basketball Family" => "https://thestagecircuit.com/wp-content/uploads/2024/01/DNABball400x300.png", "Rise Basketball" => "https://thestagecircuit.com/wp-content/uploads/2024/01/RiseCanada400x300.png", "Port City" => "https://thestagecircuit.com/wp-content/uploads/2024/01/PortCity400x300.png", "Emerald City" => "https://thestagecircuit.com/wp-content/uploads/2024/01/EmeraldCity400x300.png", "AZ Gremlins" => "https://thestagecircuit.com/wp-content/uploads/2024/01/gremlins400x300.png", "BC Elite Academy" => "https://thestagecircuit.com/wp-content/uploads/2024/02/bceliteacademy400x300.png", "True North Basketball Academy" => "https://thestagecircuit.com/wp-content/uploads/2024/02/TrueNorthBasketballAcademy400x300.png", "Wildcats Elite" => "https://thestagecircuit.com/wp-content/uploads/2024/02/WildcatsElite400x300.png", "Crafted Basketball" => "https://thestagecircuit.com/wp-content/uploads/2024/02/Crafted400x300.png", "JGECV" => "https://thestagecircuit.com/wp-content/uploads/2024/02/JGECV400x300.png", "Uptempo" => "https://thestagecircuit.com/wp-content/uploads/2024/02/Up-tempo400x300.png",  "Tru Colorado" => "https://thestagecircuit.com/wp-content/uploads/2024/03/truColorado400x300.png", "Macon Progress" => "https://thestagecircuit.com/wp-content/uploads/2024/03/Macon-Progress-BB-Wix.webp", "Team Elite" => "https://thestagecircuit.com/wp-content/uploads/2024/03/TeamElite400x300.png", "True North Elite" => "https://thestagecircuit.com/wp-content/uploads/2024/03/Untitled-2.png");

$gold_teams = array(  "Dynasty" => "Portland, OR",  "Gamepoint Basketball" => "San Diego, CA",  "Future Elite" => "Valencia, CA",  "Hoop Nation" => "Corona, CA",  "Lakeshow" => "Danville, CA",  "Az Storm" => "Peoria, AZ",  "San Diego Allstars" => "San Diego, CA",  "Northwest Greyhounds" => "Tacoma, WA",  "SUSA" => "Cedar City, UT",  "Arizona Prime" => "Mesa, AZ",  "AK Rivals" => "Wasilla, AK",  "San Francisco Rebels" => "San Francisco, CA",  "Phoenix Runnin’ Rebels" => "Phoenix, AZ",  "Team Zona" => "Phoenix, AZ",  "Meta Hoops" => "Boise, ID",  "Coastal Elite" => "San Diego, CA",  "PHPS" => "Elk Grove, CA",  "Bay City Warriors" => "San Francisco, CA",  "Swoosh Elite" => "Fresno, CA",  "SacTown Pharaohs" => "Folsom, CA",  "NorCal Prep" => "Martinez, CA",  "Project excellence" => "Toronto, Ontario", "OGP Anaheim" => "Anaheim, CA",  "I Can Allstars" => "Compton, CA",  "Beauchamp Elite" => "Seattle, WA",  "Team Nation Red" => "Maypearl, TX",  "The Right Way Academy Miners" => "Oakland, CA",  "Rize Elite" => "Rocklin, CA",  "CT Northstars Elite" => "Hartford, CT",  "Localhoops Training Academy" => "Bellevue, WA",  "Utah Hard Knox" => "Syracuse, UT",  "West Coast Finest" => "San Diego, CA",  "SF Work Hard Play Hard" => "San Francisco, CA",  "FLASH! ELITE" => "Dallas, TX",  "AZ Grassroots" => "Phoenix, AZ",  "Evolve Performance" => "Oakland, CA", "OGP Ladera" => "Ladera Ranch, CA", "Team Norcal" => "East Palo Alto, CA", "Prolific Sports Club" => "Calgary, AB", "E.A. Prep Stars" => "Charlotte, NC", "Sacramento Renegades" => "Sacramento, CA", "Utah Valley Prime" => "Orem, UT", "Control Chaos" => "Roseville, CA", "LA Select" => "Glendale, CA", "Wolf Pack Training D1" => "Orange County, CA", "Colorado Magic" => "Denver, CO", "YBA Aftermath" => "Rocklin, CA",  "Team Esface Basketball Academy" => "Redwood City, CA", "NW Drip" => "Kent, WA", "Team California" => "Alameda, CA", "We Rise Elite" => "Honolulu, Hi", "UBC Elite" => "Salt Lake City, UT", "California Select/Sixth Man" => "San Diego", "IE Fire" => "Temecula, CA", "Wildcats Elite" => "Fresno, CA", "Evolution Basketball" => "San Mateo, CA", "DNA Basketball Family" => "Twin Falls, ID", "Rise Basketball" => "Calgary, AB", "Port City" => "Stockton, CA", "Emerald City" => "Seattle, WA", "AZ Gremlins" => "Pheonix, AZ", "BC Elite Academy" => "Vancouver, BC", "True North Basketball Academy" => "Edmonton, AB", "Wildcats Elite" => "Fresno, CA", "Crafted Basketball" => "Billings, MT", "JGECV" => "Fresno, CA", "Uptempo" => "Canyon County, ID", "Tru Colorado" => "Centennial, CO", "Macon Progress" => "Portland, OR", "Team Elite" => "San Jose, CA", "True North Elite" => "Portland, OR");


?>


<!-- </div></div></section> -->
<figure class="wp-block-image alignfull small-margin-top medium-margin-bottom img-wide"><img src="https://thestagecircuit.com/wp-content/uploads/2023/12/GoldBanner.jpg" alt="Open Gym Premier Facility Pic" class="wp-image-1212"></figure>
                  <section class="site-main ">
                  <div class="grid-x grid-margin-x"><div class="cell small-12"></div></div>

     

                    
                    
<!-- <div class="nft">
    <div class='main'>
      <img class='tokenImage' src="https://thestagecircuit.com/wp-content/themes/tscircuit-press/assets/team-logos/OGP-Anaheim.png" alt="NFT" />
      <h2 style="color: #fefefe;">OGP Anaheim</h2>
      <p class='description' style="color: #fefefe;">Anaheim, CA</p> -->
<!--       <div class='tokenInfo'>
        <div class="price">
          <ins>◘</ins>
          <p>0.031 ETH</p>
        </div>
        <div class="duration">
          <ins>◷</ins>
          <p>11 days left</p>
        </div>
      </div> -->
<!--       <hr class="title_team_break" />
      <div class='team_creator'>
        <div class='img_wrapper'>
          <img class="sponsor_img" src="https://thestagecircuit.com/wp-content/uploads/2023/05/adidas-gold.png" alt="Creator" />
        </div>
          <p class="sponsor_text">Adidas Gold Teams</p>
      </div>
    </div>
  </div> -->
                    
                    
<div class="">
  <section id="content" class="grid-x grid-margin-x site-main large-padding-top xlarge-padding-bottom gold-team-page" role="main">
    <div class="cell small-12" id="allTournamentBody">
      
<!--       <div class="goldAdidas__wrap large-margin-bottom">
              <div class="goldAdidas__info">
                  <h1 class="goldAdidas__heading">Adidas Gold Teams</h1>
                  
                
                  </div></div></section>
                  <figure class="wp-block-image alignfull small-margin-top medium-margin-bottom img-wide"><img src="https://thestagecircuit.com/wp-content/uploads/2023/03/AdidasGoldBanner.jpg" alt="Open Gym Premier Facility Pic" class="wp-image-1212"></figure>
                  <section class="site-main ">
                  <div class="grid-x grid-margin-x"><div class="cell small-12"></div></div>
                
                
              </div>
      </div> -->
<!--        -->
      
      
      
      
      
<!--        -->
      
      
      
      <div class="master-container">
        
      
        
        
        
        
        <?php 
         echo"<div class='gold-container'>";        
         foreach($gold_teams as $index => $location){
           echo"
                <div class='nft'>
                  <div class='main'>
                    <img class='tokenImage' src='$gold_teams_images[$index]' alt='NFT' />
                    <h2 class='gold-name' style='color: #fefefe;'>$index</h2>
                    <p class='description' style='color: #fefefe;'>$location</p>
                    <hr class='title_team_break' />
                    <div class='team_creator'>
                      <div class='img_wrapper'>
                        <img class='sponsor_img' src='https://thestagecircuit.com/wp-content/uploads/2023/05/adidas-gold.png' alt='Creator' />
                      </div>
                      <p class='sponsor_text'>Adidas Gold Programs</p>
                    </div>
                  </div>
                </div>
                ";
           
           
         }
                    
         echo"
              </div>
              <a class='button gold-teams-page' href='https://thestagecircuit.com/wp-content/uploads/2024/09/Adidas-3SGB-Guide-Book.pdf'>Adidas 3SGB Guide Book</a>
              ";
                    
                    
                    
?>
        
        
        
        </div>
      
      
    </div>
  </section>
</div>
<?php echo $tournament_awards['aw_script']; get_footer(); ?>
<?php
/**
 * The front page template
 * @package OGP  Press
 * @since OGP 1.0.0
 */

// News query for the slider
$news_feat = new WP_Query( array( 'category_name' => 'Featured', 'posts_per_page' => 6 ) );

//https://dev.grassroots365.com/wp-content/uploads/display-assets/event-promo-tscircuit.jpg
//https://dev.grassroots365.com/wp-content/uploads/2017/11/tscircuit-posts-banner.jpg
get_header();

//see if we need a splash display
$tscircuit_ad_info = tscircuit_start_ads( $post->ID );

$default_img = get_site_url() . '/wp-content/themes/tscircuit-press/tscircuit_default_placeholder.gif';
$bigBG = 'https://thestagecircuit.com/' . '/wp-content/uploads/2022/06/The-Stage-Act-3-883.jpg';
$smallBG = 'https://thestagecircuit.com/' . '/wp-content/uploads/2022/06/The-Stage-Act-3-883.jpg';

$tscircuit_layout_type = get_option( 'tscircuit_layout' );
if( $tscircuit_layout_type['front_layout']['type'] === 'tiles' && count($news_feat->posts) === 6 ){
  //trigger for tile video support
  $tile_vid = false;
  $tile_video_settings = [];

  //get tile banner
	$tscircuit_tile_banner = get_option( 'tscircuit_display' );
	//reassign to focus on tile banner
	$tscircuit_tile_banner = $tscircuit_tile_banner['site_4'];
  $tscircuit_tile_banner_build = '';
  //build tile banner from global settings if we have data
  if ( !empty($tscircuit_tile_banner['title']) ) {
    if ( !empty($tscircuit_tile_banner['link']) ) {
      $tscircuit_tile_banner_build .= '<h2 class="no-margin"><a href="' . $tscircuit_tile_banner['link'] . '">' . $tscircuit_tile_banner['title'] . '</a></h2>';
    } else {
      $tscircuit_tile_banner_build .= '<h2 class="no-margin">' . $tscircuit_tile_banner['title'] . '</h2>';
    }
  }
  if ( !empty($tscircuit_tile_banner['sub_title']) ) $tscircuit_tile_banner_build .= '<p class="no-margin">' . $tscircuit_tile_banner['sub_title'] . '</p>';
  function tscircuit_tile_template( $target_num, $news_feat, $classes ) {
    $tile_type = get_post_meta($news_feat->posts[$target_num]->ID, 'video_head', true);
    if( empty($tile_type) ) {
      $tile_type = '<img src="' . (( has_post_thumbnail($news_feat->posts[$target_num]->ID) ) ? get_the_post_thumbnail_url( $news_feat->posts[$target_num]->ID, "featured-tile" ) : get_site_url() . "/wp-content/themes/tscircuit-press/assets/tscircuit_profile_placeholder_640x640.jpg") . '" alt="' . $news_feat->posts[$target_num]->post_title . '" />';
    } else {
      $video_settings = explode(":", $tile_type);
      if( $video_settings[0] === 'youtube' ) {
        global $tile_vid;
        global $tile_video_settings;
        $tile_type = '<div id="tile_player_' . $news_feat->posts[$target_num]->ID . '"></div>';
        $tile_vid = true;
        $tile_video_settings[] = (object) [
          'id' => 'tile_player_' . $news_feat->posts[$target_num]->ID,
          'data'=> (object)[
            'height' => '640.125',
            'width' => '1138',
            'videoId' => $video_settings[1],
            'playerVars' => (object)[
              'controls' => 0,
              'fs'  => 0,
              'modestbranding'  => 1,
              'enablejsapi' => 1
            ]
          ]
        ];
        $classes .= ' responsive-embed';
        //og code before embed method of youtube auto play
//         $tile_type = '<iframe type="text/html" width="1138" height="640.125"
// src="https://www.youtube.com/embed/' . $video_settings[1] . '?autoplay=1&controls=0&enablejsapi=1&loop=1&modestbranding=1&fs=0" frameborder="0"></iframe>';
//         $classes .= ' responsive-embed';
      }
    }
    return '        <div id="news-' . $news_feat->posts[$target_num]->ID . '" class="black-border thick-border tile relative maximum-height">
          <a href="' . get_permalink($news_feat->posts[$target_num]->ID) . '" class="' . $classes . '">' . $tile_type . '</a>
          <h1 class="article-info">
            <a href="' . get_permalink($news_feat->posts[$target_num]->ID) . '">' . $news_feat->posts[$target_num]->post_title . '</a>' . 
            (( !empty($news_feat->posts[$target_num]->post_excerpt) ) ? "<p class=\"no-margin cute orange text-lowercase\">" . $news_feat->posts[$target_num]->post_excerpt . "</p>" : "") . 
          '</h1>
        </div>';
  } ?>

<div class="parent">

<!--       <img class="" src="<?php echo ( has_post_thumbnail() ) ? the_post_thumbnail_url( 'featured-home' ) : 'http://image.mlive.com/home/mlive-media/width960/img/kalamazoogazette/photo/2016/12/22/-c8733c1e608c238b.JPG'; ?>" alt="<?php echo get_the_title(); ?>"
      /> -->
<!--       hello-->
      <figure class=" size-full is-resized">
        <img srcset="<?php echo $smallBG ?> 1920w, <?php echo $bigBG ?> 2400w" src="<?php $smallBG ?>"  alt="" class="wp-image-51" />
      </figure>
<!--      <?php echo "Today is " . wp_date("Y/m/d h:i:s") . "<br>"; ?> -->

      
<!--       <div class="register-button">
        <a target="_blank" rel="noopener noreferrer"  class="registration-text grid-y align-top buttonization registration" href="https://dev.thestagecircuit.com/registration-page/"> Apply to Participate</a>
      </div> -->
      
      <div class="parent-2 ">
        
        <div class="grid-x align-center">
         <img class="img-2" src="https://thestagecircuit.com/wp-content/uploads/2024/09/The-Stage-WHT.png">
        </div>

        
      </div>
</div>

<section class="site-main width-hd hero-tiles<?php if ( $tscircuit_ad_info['go'] ) echo $tscircuit_ad_info['ad_section_class']; ?>">
    <?php if ( $tscircuit_ad_info['go'] ) echo $tscircuit_ad_info['ad_before'] . $tscircuit_ad_info['ad_content'] . $tscircuit_ad_info['ad_after']; ?>
    <div class="grid-x white-border thick-border" style="overflow-x:scroll; flex-wrap: nowrap;">
  
            <div class="cell small-4 maximum-height">
              <?php echo tscircuit_tile_template( 0, $news_feat, 'tile-image' ); ?>
            </div>
            <div class="cell small-4 maximum-height">
              <?php echo tscircuit_tile_template( 1, $news_feat, 'tile-image' ); ?>
            </div>
            <div class="cell small-4 maximum-height">
              <?php echo tscircuit_tile_template( 2, $news_feat, 'tile-image' ); ?>
            </div>
<!--             <div class="cell small-4 maximum-height">
              <?php echo tscircuit_tile_template( 3, $news_feat, 'tile-image' ); ?>
            </div> 
            <div class="cell small-4 maximum-height">
              <?php echo tscircuit_tile_template( 4, $news_feat, 'tile-image' ); ?>
            </div>
            <div class="cell small-4 maximum-height">
              <?php echo tscircuit_tile_template( 5, $news_feat, 'tile-image' ); ?>
            </div>  -->
        <?php if( $tscircuit_tile_banner_build !== '' ) : ?>
        <div class="cell shrink">
          <div class="grid-x maximum-height">
            <div class="cell small-12 text-center small-small-padding large-padding callout secondary no-margin white-border thick-border">
              <?php echo $tscircuit_tile_banner_build; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
  </div>
    
<!-- <div style="text-align: right; margin-right: 2rem;">

<button class="button slider-btn" id="newsLeft" disabled><</button>
<button class="button slider-btn" id="newsRight">></button>
</div> -->
  
  <br><br>
  </section>

<!--   <section class="site-main width-hd hero-tiles<?php if ( $tscircuit_ad_info['go'] ) echo $tscircuit_ad_info['ad_section_class']; ?>">
    <?php if ( $tscircuit_ad_info['go'] ) echo $tscircuit_ad_info['ad_before'] . $tscircuit_ad_info['ad_content'] . $tscircuit_ad_info['ad_after']; ?>
    <div class="grid-x black-border thick-border">
      <div class="cell medium-8">
        <div class="grid-y grid-frame small-block">
          <div class="cell auto">
            <div class="grid-x maximum-height">
              <div class="cell small-6 maximum-height">
                <?php echo tscircuit_tile_template( 0, $news_feat, 'tile-image' ); ?>
              </div>
              <div class="cell small-6 maximum-height">
                <?php echo tscircuit_tile_template( 1, $news_feat, 'tile-image' ); ?>
              </div>
            </div>
          </div>
          <?php if( $tscircuit_tile_banner_build !== '' ) : ?>
          <div class="cell shrink">
            <div class="grid-x maximum-height">
              <div class="cell small-12 text-center small-small-padding large-padding callout secondary no-margin black-border thick-border">
                <?php echo $tscircuit_tile_banner_build; ?>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <div class="cell auto">
            <div class="grid-x maximum-height">
              <div class="cell small-6 maximum-height">
                <?php echo tscircuit_tile_template( 2, $news_feat, 'tile-image' ); ?>
              </div>
              <div class="cell small-6 maximum-height">
                <?php echo tscircuit_tile_template( 3, $news_feat, 'tile-image' ); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cell medium-4">
        <div class="grid-x">
          <div class="cell small-6 medium-12">
            <?php echo tscircuit_tile_template( 4, $news_feat, 'tile-image' ); ?>
          </div>
          <div class="cell small-6 medium-12">
            <?php echo tscircuit_tile_template( 5, $news_feat, 'tile-image' ); ?>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <?php
  //$featured_events_arr = g365_conn( 'g365_display_events', [65, 6] );
  $tscircuit_potm = get_post_meta($post->ID, 'tscircuit_potm', true);
  $tscircuit_ctotm = get_post_meta($post->ID, 'tscircuit_ctotm', true);
  if( !empty( $tscircuit_potm ) || !empty( $tscircuit_ctotm ) || !empty( $featured_events_arr ) ) :
?>
    <section class="site-main small-padding-top xlarge-padding-bottom grid-container">
      <div class="grid-x">
        <div id="main" class="small-12 cell">
          <?php if( !empty($featured_events_arr) ) : ?>
          <div class="tiny-padding gset no-border">
            <h2 class="entry-title text-center screen-reader-text"><a href="/calendar">Featured Events</a></h2>
          </div>
          <div class="widget-wrapper medium-margin-bottom">
            <div class="grid-x small-up-2 medium-up-3 large-up-6 text-center profile-feature profile-widget">
              <?php foreach( $featured_events_arr as $dex => $obj ) : ?>
              <div class="cell">
                <div class="small-margin-bottom">
                  <a href="<?php echo $obj->link; ?>" target="_blank">
                <img src="<?php echo (!empty($obj->logo_img)) ? $obj->logo_img : $default_event_img ?>" alt="<?php echo $obj->name; ?> official logo" />
                <p>
                  <?php echo ( empty($obj->short_name) ) ? $obj->name : $obj->short_name; ?><br>	
                  <small class="tiny-margin-top block"><?php echo tscircuit_build_dates($obj->dates); ?></small>
                </p>
              </a>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <a class="button expanded no-margin-bottom" href="/calendar">Full Calendar</a>
          </div>
          <?php endif;
      if( !empty($tscircuit_potm) ) : ?>
          <div class="widget-wrapper medium-margin-bottom">
            <div class="grid-x">
              <div class="cell">
                <img src="<?php echo $tscircuit_potm; ?>" alt="Players of the month by region. <?php the_modified_date(); ?>" />
              </div>
            </div>
          </div>
          <?php endif; ?>
          <?php if( !empty($tscircuit_ctotm) ) : ?>
          <div class="widget-wrapper medium-margin-bottom">
            <div class="grid-x">
              <div class="cell">
                <img src="<?php echo $tscircuit_ctotm; ?>" alt="Club Team of the month. <?php the_modified_date(); ?>" />
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <?php endif; //end ptom section ?>

    <?php } else { //end tile layout hero section, begin standard featured post rotator ?>

    <!--  add the main image here to display-->


    <!--        ------------------------------------------------------------------------------------------------------>



    <?php if ( $tscircuit_ad_info['go'] ) echo $tscircuit_ad_info['ad_before'] . $tscircuit_ad_info['ad_content'] . $tscircuit_ad_info['ad_after']; ?>

    <?php if ( $news_feat -> have_posts() ) : while ( $news_feat -> have_posts() ) : $news_feat -> the_post(); ?>

    <div class="parent">

<!--       <img class="" src="<?php echo ( has_post_thumbnail() ) ? the_post_thumbnail_url( 'featured-home' ) : 'http://image.mlive.com/home/mlive-media/width960/img/kalamazoogazette/photo/2016/12/22/-c8733c1e608c238b.JPG'; ?>" alt="<?php echo get_the_title(); ?>"
      /> -->
<!--       hello-->
      <figure class=" size-full is-resized hide">
        <img srcset="<?php echo $smallBG ?> 1920w, <?php echo $bigBG ?> 2400w" src="<?php $smallBG ?>"  alt="" class="wp-image-51" />
      </figure>
      <video class="hero__video" autoplay="autoplay" loop="loop" muted="muted" playsinline="">
        <source src="https://thestagecircuit.com/wp-content/uploads/2024/03/TheStage_Web.mp4">
      </video>
<!--      <?php echo "Today is " . wp_date("Y/m/d h:i:s") . "<br>"; ?> -->

      
<!--       <div class="register-button">
        <a target="_blank" rel="noopener noreferrer"  class="registration-text grid-y align-top buttonization registration" href="https://dev.thestagecircuit.com/registration-page/"> Apply to Participate</a>
      </div> -->
      
      <div class="parent-2 ">
        
        <div class="grid-x align-center">
         <img class="img-2" src="<?php echo get_site_url(); ?>/wp-content/themes/tscircuit-press/assets/tiny-logos/The-Stage-Logo-tiny.png">
        </div>
        
        
<!--         <div class="grid-x align-center">
            <a class="img-3 grid-x align-center" target="_blank" rel="noopener noreferrer" href="https://comptonmagic.net/"><img  src="<?php echo get_site_url(); ?>/wp-content/themes/tscircuit-press/assets/tiny-logos/CM-Logo.png"></a>  
            <a class="img-5 grid-x align-center" target="_blank" rel="noopener noreferrer" href="https://opengympremier.com/"><img  src="<?php echo get_site_url(); ?>/wp-content/themes/tscircuit-press/assets/tiny-logos/open_gym_premier_tiny_dk.png"></a>
        </div> -->
       
<!--         <div class="events-container">
          
          <div>
            <img class="act" src="<?php echo get_site_url(); ?>/wp-content/themes/tscircuit-press/assets/tiny-logos/The-Stage-Logo-tiny.png">
            <p class="act-spacer"><strong>ACT I</strong></p>
            <p class="date tiny-margin-bottom">April 21 - 23, 2023</p>
            <a target="_blank" rel="noopener noreferrer"  class="act-link grid-y align-top buttonization small-margin-bottom" href="https://grassroots365.com/product/act-i/"> High School</a>
          </div>
          
          <div>
            <img class="act" src="<?php echo get_site_url(); ?>/wp-content/themes/tscircuit-press/assets/tiny-logos/The-Stage-Logo-tiny.png">
            <p class="act-spacer"><strong>ACT II</strong></p>
            <p class="date tiny-margin-bottom">April 28 - 30, 2023</p>
            <a target="_blank" rel="noopener noreferrer"  class="act-link grid-y align-top buttonization small-margin-bottom" href="https://grassroots365.com/product/act-ii/"> High School</a>
          </div>
          
          <div>
            <img class="act" src="<?php echo get_site_url(); ?>/wp-content/themes/tscircuit-press/assets/tiny-logos/The-Stage-Logo-tiny.png">
            <p class="act-spacer"><strong>ACT III</strong></p>
            <p class="date tiny-margin-bottom">July 6 - 9, 2023</p>
            <a target="_blank" rel="noopener noreferrer"  class="act-link grid-y align-top buttonization small-margin-bottom" href="https://grassroots365.com/product/act-iii/"> High School</a>
          </div> -->
          
<!--           <div>
            <img class="act" src="<?php echo get_site_url(); ?>/wp-content/themes/tscircuit-press/assets/tiny-logos/NorCalLive-Spring-400x300.png">
            <p class="act-spacer"><strong>Spring NorCal Live</strong></p>
            <p class="date tiny-margin-bottom">April 28 – 30, 2023</p>
            <a target="_blank" rel="noopener noreferrer"  class="act-link grid-y align-top buttonization small-margin-bottom" href="https://grassroots365.com/product/spring-norcal-live/"> High School</a>
          </div>
          
          <div>
            <img class="act" src="<?php echo get_site_url(); ?>/wp-content/themes/tscircuit-press/assets/tiny-logos/NorCalLive-Summer-400x300.png">
            <p class="act-spacer"><strong>Summer NorCal Live</strong></p>
            <p class="date tiny-margin-bottom">July 6 – 9, 2023</p>
            <a target="_blank" rel="noopener noreferrer"  class="act-link grid-y align-top buttonization small-margin-bottom" href="https://grassroots365.com/product/summer-norcal-live/"> High School</a>
          </div> -->
          
<!--         </div> -->
        
      </div>
      </div>

      <?php endwhile; wp_reset_postdata(); endif; ?>



      <!--        ------------------------------------------------------------------------------------------------------>





      <?php } //end default hero featured image section ?>

      <section id="content" class="site-main small-padding-top xlarge-padding-bottom grid-container">

        <?php //if we have page content
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php the_content(); ?>

        <?php endwhile; endif; ?>

      </section>

      <?php
//if we have a splash graphic, add  the elements to support, part 1
if( !empty($tscircuit_ad_info['splash']) ) echo $tscircuit_ad_info['splash'];

get_footer();

//if we have a splash graphic, initialize it now that foundation() has started, part 2
if( !empty($tscircuit_ad_info['splash']) ) echo '<script type="text/javascript">
    var tscircuit_closed = localStorage.getItem("tscircuit_close_today");
    var tscircuit_closed_date = localStorage.getItem("tscircuit_close_today_date");
    var tscircuit_now_date = new Date();
    if( tscircuit_closed_date !== null && new Date(tscircuit_closed_date).getDate() !== tscircuit_now_date.getDate() ) {
      localStorage.removeItem("tscircuit_close_today");
      localStorage.removeItem("tscircuit_close_today_date");
      tscircuit_closed = null;
    }
    if( tscircuit_closed === null ) {
      (function($){$("#tscircuit_home_reveal").foundation("open");})(jQuery);
    }
  </script>';

if( $tile_vid ) {
  print_r(
    '<script>
      var tag = document.createElement("script");
      tag.src = "https://youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName("script")[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      var tile_players = ' . json_encode( $tile_video_settings) . ';
      function onYouTubeIframeAPIReady() {
        tile_players.forEach( function( vid_settings, dex ) {
          vid_settings.data.events = {
            "onReady": onPlayerReady,
            "onStateChange": onPlayerStateChange
          };
          tile_players[dex]["video_ref"] = new YT.Player( vid_settings.id, vid_settings.data);
        });
      }
       function onPlayerReady(event) {
         event.target.playVideo();
         event.target.mute();
       }
       function onPlayerStateChange(event) {
        if( event.data === 0 ){
         event.target.playVideo();
        }
       }
    </script>'
  );
}

    
    
    
?>
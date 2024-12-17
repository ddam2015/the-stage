<style>
/*Event box animation*/
.glow-box{
  content: '';
  background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #fffb00, #fffb00, #ff0000, #ff0000, #fffb00, #ff0000);
  top: -2px;
  left: -2px;
  background-size: 400%;
  width: calc(100% + 4px);
  height: calc(100% + 4px);
  animation: glowing 60s linear infinite;
  transition: opacity .3s ease-in-out;
  border-radius: 10px;
}
.glow-box:active{
  color: #000
}
.glow-box:active:after{
  background: transparent;
}
.glow-box:hover{
  opacity: 1;
}
.glow-box:after{
  z-index: -1;
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: #fff;
  left: 0;
  top: 0;
  border-radius: 10px;
}
@keyframes glowing{
  0%{ background-position: 0 0; }
  50%{ background-position: 400% 0; }
  100%{ background-position: 0 0; }
}
/*End event box animation*/  
/* Remove icon styles */
.rm_btn{
  display: block;
  background-color: #c0392b;
  width: 100px;
  height: 34px;
  line-height: 35px;
  margin: auto;
  color: #fff;
  position: relative;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  cursor: pointer;
  overflow: hidden;
  border-radius: 5px;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.3);
  transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4);
}
.rm_btn span,
.rm_btn .rm_icon{
  display: block;
  height: 100%;
  text-align: center;
  position: absolute;
  top: 0;
}
.rm_btn span{
  width: 72%;
  line-height: inherit;
  font-size: 10px;
  text-transform: uppercase;
  left: 0;
  transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4);
}
.rm_btn span:after{
  content: "";
  background-color: #a53125;
  width: 2px;
  height: 70%;
  position: absolute;
  top: 15%;
  right: -1px;
}
.rm_btn .rm_icon{
  width: 28%;
  right: 0;
  transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4);
  top: -2px;
}
.rm_btn .rm_icon .fa{
  font-size: 16x;
  vertical-align: middle;
  transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4), height 0.25s ease;
}
.rm_btn .rm_icon .fa-remove{
  height: 36px;
}
.rm_btn .rm_icon .fa-check{
  display: none;
}
.rm_btn.success span, .rm_btn:hover span{
  left: -72%;
  opacity: 0;
}
.rm_btn.success .rm_icon, .rm_btn:hover .rm_icon{
  width: 100%;
}
.rm_btn.success .rm_icon .fa, .rm_btn:hover .rm_icon .fa{
  font-size: 24px;
}
.rm_btn.success{
  background-color: #27ae60;
}
.rm_btn.success .rm_icon .fa-remove{
  display: none;
}
.rm_btn.success .rm_icon .fa-check{
  display: inline-block;
}
.rm_btn:hover{
  opacity: 0.9;
}
.rm_btn:hover .rm_icon .fa-remove{
  height: 46px;
}
.rm_btn:active{
  opacity: 1;
}
.rm_x{
  font-size: 14px;
  font-weight: bolder;
  font-style: inherit;
  margin: 0 2px 0 0px;
  color: #fff;
}
.rm_fav{
/*   display: flex; */
}
.main_fav{
  margin: 0 auto;
  max-width: 1200px;
}
  /*End remove btn*/
  
  /*View full list animation*/
.view_full_list{
  position: sticky;
  top: 50%;
  /* transform: translate(-50%, -50%); */
  width: 250px;
}
.link_view_full_list{
  position: relative;
}

.view_full_list a{
  display: block;
  width: 280px;
  height: 50px;
  line-height: 50px;
  font-weight: bold;
  text-decoration: none;
  background: #333;
  text-align: center;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 1px;
  border: 3px solid #333;
  transition: all .35s;
}

.icon{
  width: 50px;
  height: 50px;
  border: 3px solid transparent;
  position: absolute;
  transform: rotate(45deg);
  right: 0;
  top: 0;
  z-index: -1;
  transition: all .35s;
}

.icon svg{
  width: 30px;
  position: absolute;
  top: calc(50% - 15px);
  left: calc(50% - 15px);
  transform: rotate(-45deg);
  fill: #fd7c77;
  transition: all .35s;
}

.view_full_list a:hover{
  width: 270px;
  border: 3px solid #fd7c77;
  background: transparent;
  color: #2d2929;
}

.view_full_list a:hover + .icon{
  border: 3px solid #fd7c77;
  right: -25%;
}
/*End view list animation*/

/**************************
**Favorit icon animation***
**************************/
.btn-flip {
  opacity: 1;
  outline: 0;
  color: #fff;
  line-height: 40px;
  position: relative;
  text-align: center;
  letter-spacing: 1px;
  display: inline-block;
  text-decoration: none;
  font-family: "Open Sans";
  text-transform: uppercase;
}
.btn-flip:hover:after {
  opacity: 1;
  transform: translateY(0) rotateX(0);
}
.btn-flip:hover:before {
  opacity: 0;
  transform: translateY(50%) rotateX(90deg);
}
.btn-flip:after {
  top: 0;
  left: 0;
  opacity: 0;
  width: 100%;
  color: #323237;
  display: block;
  transition: 0.5s;
  position: absolute;
  background: transparent;
  content: attr(data-back);
  transform: translateY(-50%) rotateX(90deg);
}
.btn-flip:before {
  top: 0;
  left: 0;
  opacity: 1;
  color: #adadaf;
  display: block;
/*   padding: 0 30px; */
  line-height: 40px;
  transition: 0.5s;
  position: relative;
  background: transparent;
  content: attr(data-front);
  transform: translateY(0) rotateX(0);
}
/******************************
**End Favorit icon animation***
******************************/
.max-width-1200{
  max-width: 1200px;
  margin: 0 auto;
}  
.fav_note{
  border: 1px solid #c8c6c6;
  padding: 10px;
}
.grid-x.home_fav_box{
  padding: 34px;
  border: 1px solid #eb0906;
  margin: 0 0 10px 0;
  box-shadow: 0 0 15px 0 #535353;
}
.fav_animation:before{
  content: "⭐️";
}
.h_ev_box, .h_fav_box{
  border: 1px solid #b7b5b5;
}
.ev_inner{
  background-color: #fff;
  border-radius: 10px;
  margin: 4px;
}
</style>
<?php global $wp_query; //print_r($wp_query->query_vars); ?>
<div>
  <ul class="pl_profile_ul pl_profile_ul--player small-up-5 medium-up-5 text-center large-padding-bottom">
    <li class="tabs-title cell<?php echo ( empty($wp_query->query_vars['tscircuit-home']) || strtolower($wp_query->query_vars['tscircuit-home']) === 'home' ) ? ' is-active': ''; ?>">
      <a href="<?php echo get_site_url(); ?>/my-account/tscircuit-home/home/" class="profile-title profile__nav--item block"<?php echo ( empty($wp_query->query_vars['tscircuit-home']) || strtolower($wp_query->query_vars['tscircuit-home']) === 'home' ) ? ' aria-selected="true"': ''; ?>>Home</a>
    </li>
    <li class="tabs-title cell<?php echo ( strtolower($wp_query->query_vars['tscircuit-home']) === 'stats' ) ? ' is-active': ''; ?>">
      <a href="<?php echo get_site_url(); ?>/my-account/tscircuit-home/stats/" class="profile-title profile__nav--item block"<?php echo ( strtolower($wp_query->query_vars['tscircuit-home']) === 'stats' ) ? ' aria-selected="true"': ''; ?>>Stats</a>
    </li>
    <li class="tabs-title cell<?php echo ( strtolower($wp_query->query_vars['tscircuit-home']) === 'team-standings' ) ? ' is-active': ''; ?>">
      <a href="<?php echo get_site_url(); ?>/my-account/tscircuit-home/team-standings/" class="profile-title profile__nav--item block"<?php echo ( strtolower($wp_query->query_vars['tscircuit-home']) === 'team-standings' ) ? ' aria-selected="true"': ''; ?>>Team Standings</a>
    </li>
    <li class="tabs-title cell<?php echo ( strtolower($wp_query->query_vars['tscircuit-home']) === 'favorites' ) ? ' is-active': ''; ?>">
      <a href="<?php echo get_site_url(); ?>/my-account/tscircuit-home/favorites/" class="profile-title profile__nav--item block"<?php echo ( strtolower($wp_query->query_vars['tscircuit-home']) === 'favorites' ) ? ' aria-selected="true"': ''; ?>>Favorites</a>
    </li>
    <li class="tabs-title cell<?php echo ( strtolower($wp_query->query_vars['tscircuit-home']) === 'overview' ) ? ' is-active': ''; ?>">
      <a href="<?php echo get_site_url(); ?>/my-account/tscircuit-home/overview/" class="profile-title profile__nav--item block"<?php echo ( strtolower($wp_query->query_vars['tscircuit-home']) === 'overview' ) ? ' aria-selected="true"': ''; ?>>Overview</a>
    </li>
  </ul>
</div>
  <?php switch($wp_query->query_vars['tscircuit-home']){ case '': case 'home': $ev_acts = g365_fn(['fn_name'=>'g365_get_event', 'arguments'=>[[''], 'acts']]); $ev_acts = json_decode(json_encode($ev_acts), true); //echo "<pre>"; print_r($ev_act); echo "</pre>"; ?>
  <div class="medium-padding">
    <h1>Digital Coach Packets</h1>
    <p>Welcome to the <span style="font-weight:bolder;text-decoration:underline">The Stage Digital Coaching Dashboard.</span> Here you'll be able to view teams, players and stats from events.</p><br/>
    <p>Add players to your favorites list for easy access, and add your notes on them.</p>
    <div class="grid-x">
      <div class="small-12 medium-6 large-6 small-padding-right">
<!--         <div class="small-12 medium-12 large-12">Search Player</div> -->
        <div class="h_ev_box small-12 medium-12 large-12 medium-padding">
          <h3>Events</h3>
          <div class="grid-x small-up-2 medium-up-4 large-up-4 text-center">
            <?php foreach($ev_acts as $ev_act): ?>
              <div class="cell small-margin"><!-- glow-box -->
                <div class="ev_inner">
                  <img class="small-margin-bottom" loading="lazy" data-src="<?php echo $ev_act['img_logo']; ?>" alt="<?php echo $ev_act['name']; ?>" src="<?php echo $ev_act['logo_img']; ?>">
                  <label class="emphasis"><?php echo $ev_act['name']; ?></label>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="h_fav_box small-12 medium-6 large-6 medium-padding">
        <h3>My Favorites</h3>
        <?php $player_data = tscircuit_g365_data_xfer(['db_tb'=>'favorites', 'qn_type'=>1, 'user_id'=>get_current_user_id(), 'limit'=>'3'], 'SELECT'); if(!empty($player_data)): foreach($player_data as $pl_data): $pl_id = $pl_data['player_id']; $pl_note = json_decode($pl_data['notes'], true); $pl_data_field = json_decode($pl_data['pl_data'], true); ?>
          <div class="grid-x home_fav_box">
            <div class="small-12 medium-6 large-6">
              <div class="cell" data-alphabet="A">
                <a class="emphasis watchlist__player" href="https://grassroots365.com/player/<?php echo $pl_data_field['pl_nickname']; ?>" target="_blank">
                    <img class="watchlist__player-img small-margin-bottom" loading="lazy" data-src="<?php echo $pl_data_field['img_link']; ?>" alt="Player headshot for <?php echo $pl_data_field['pl_name']; ?>" src="<?php echo $pl_data_field['img_link']; ?>"><br>
                    <p><?php echo $pl_data_field['pl_name']; ?></p>
                </a>
              </div>
            </div>
            <div class="small-12 medium-6 large-6">
              <?php echo cdp_fav_pl_info(['pl_name'=>$pl_data_field['pl_name'],'grad_year'=>$pl_data_field['grad_year'],'position'=>$pl_data_field['position'],'height'=>$pl_data_field['height'],'gpa'=>$pl_data_field['gpa'],'sat'=>$pl_data_field['sat'],'contact_info'=>$pl_data_field['contact_info']], 'pl_fav'); ?>
            </div>
            <div class="small-12 medium-12 large-12 fav_note"><h5>Notes: <?php echo $pl_note['notes']; ?></h5></div>
          </div>
        <?php endforeach; else: echo ("<p>No player is added to the favorite list</p>"); endif; ?>
<!--         <div class="view_full_list">
          <div class="link_view_full_list">
            <a href="<?php echo get_site_url() ?>/my-account/tscircuit-home/favorites/">View/Edit full list</a>
          </div>
        </div> -->
        <div class="view_full_list">
          <div class="link_view_full_list">
            <a href="<?php echo get_site_url() ?>/my-account/tscircuit-home/favorites/">View/Edit full list</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php 
    break; 
  case 'stats': tscircuit_dir_render('digital-coach-packets', 'stats', $player_id, $arg = null); 
    break;
  case 'team-standings': tscircuit_dir_render('digital-coach-packets', 'team-standings', $player_id, $arg = null); 
    break;
  case 'favorites': tscircuit_dir_render('digital-coach-packets', 'favorites', $player_id, $arg = null); 
    break;
  case 'overview': tscircuit_dir_render('digital-coach-packets', 'overview', $player_id, $arg = null);
    break;
  case 'ajax-caller': tscircuit_dir_render('', 'ajax-caller', $player_id, $arg = null);
    break;
}?>
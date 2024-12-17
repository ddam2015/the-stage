<?php
  if(!isset($_POST['roster_level']) && !isset($_POST['roster_dvs']) && !isset($_POST['stat_catagory']) && !isset($_POST['ev_val'])){
     $post_level_val = "false"; $post_dvs_val = "false"; $post_stat_val = "false"; $post_ev_val = "false";
  }else{$post_ros_level = $_POST['roster_level']; $post_dvs = $_POST['roster_dvs']; $post_stat_catagory = $_POST['stat_catagory']; $post_ev_id = $_POST['ev_val'];}
  $g365_stat_leader = g365_fn(['fn_name'=>'remote_stat_leader', 'arguments'=>[['post_level_val'=>$post_level_val, 'post_dvs_val'=>$post_dvs_val, 'post_stat_val'=>$post_stat_val, 'post_ev_val'=>$post_ev_val, 'select_level'=>$post_ros_level, 'post_dvs'=>$post_dvs, 'post_stat_catagory'=>$post_stat_catagory, 'post_ev_id'=>$post_ev_id, 'authorize_useid'=>get_current_user_id()], 'null']]);
  $g365_stat_leader = json_decode( json_encode($g365_stat_leader), true);
  $key_level = $g365_stat_leader[1];
  $stat_lists = $g365_stat_leader[2];
  $select_year = $_POST['year'];
  if(!isset($post_stat_catagory)){$post_stat_catagory = $g365_stat_leader[9];}
  $default_event_info = $g365_stat_leader[3];
  $event_info = $g365_stat_leader[4];
  $default_num_pl = 5;
  $set_top_pl_num = 50;
//   echo "<pre>"; print_r($g365_stat_leader[10]); echo "</pre>";
?>
<div>
  <form method="post" action="" id="statleader-form" class="grid-x">
    <div class="small-12 medium-12 large-3 small-padding-right" style="width: 152px">
      <select name="roster_level" id="roster_level" style="border-radius: 20px"> 
        <option value="">All Levels</option>
        <?php for($i = 8; $i <= 47; $i++): if(($i > 7 && $i < 18) || ($i > 39 && $i < 48 )):/*if-a*/ ?>
          <option <?php if(isset($post_ros_level) && $post_ros_level == $i){echo 'selected= "selected"';} ?> value="<?php echo $i ?>"><?php echo $g365_stat_leader[1][$i]; ?></option> 
        <?php endif;/*if-a*/ endfor; ?>
      </select>
    </div>
    <div class="small-12 medium-12 large-3 small-padding-right" style="width: 152px">
      <select name="roster_dvs" id="roster_dvs" style="border-radius: 20px"> 
        <option value="">All Divisions</option>
        <?php foreach($g365_stat_leader[8] as $index => $dvs_list):/*foreach-a*/ ?>
          <option <?php if(isset($post_dvs) && $post_dvs == $g365_stat_leader[8][$index]){echo 'selected= "selected"';} ?> value="<?php echo $dvs_list ?>"><?php echo $g365_stat_leader[8][$index]; ?></option> 
        <?php endforeach;/*endforeach-a*/ ?>
      </select>
    </div>
    <div class="small-12 medium-12 large-3 small-padding-right" style="width: 200px">
      <select name="stat_catagory" id="stat_catagory" style="border-radius: 20px"> 
        <?php foreach($stat_lists as $index => $stat_list): $stat_type = $stat_lists[$index]['type']; $stat_alias = $stat_lists[$index]['alias'];?>
        <option <?php if(isset($post_stat_catagory) && $post_stat_catagory == $stat_alias){echo 'selected= "selected"';} ?> value="<?php echo $stat_alias ?>"><?php echo ($stat_type."s") ?></option> 
        <?php endforeach; ?>
      </select>
    </div>
    <div class="small-12 medium-12 large-3 small-padding-right" style="width: 260px">
      <?php echo $g365_stat_leader[6]; ?>
    </div>
    <div class="small-12 medium-12 large-3 small-padding-right" style="width: 135px">
      <input type="submit" id="slb_submit_btn" value="Filter" class="spotlight__card--heading small-12 medium-12 large-3" />
    </div>
  </form>
</div>
<!-- // Event: Top 50 players(Base on selected stat catagory) -->
<?php //if( empty($event_id) && !is_numeric($select_level) ):/*if-2*/
  $ev_year = $default_pl_stats[$post_stat_catagory][0]["event_time"]; //$ev_year = g365_fn(['fn_name'=>'g365_date_format', 'arguments'=>[$ev_year, 7]]);
?>
<div id="dialong_div"></div>
<div class="all-tournament__details" style="flex-wrap: wrap;flex-direction: row;">
  <div style="flex: 0 1 100%;" class="text-center"><img class="width-50-200" src="<?php echo $event_info['logo_img']; ?>" alt="<?php echo $event_info['name']; ?>"></div>
  <div style="flex: 0 1 100%;" class="text-center"><h4><?php echo date("Y",strtotime($event_info['eventtime'])); ?></h4></div>
  <div style="flex: 0 1 100%;" class="text-center"><h4><?php echo $event_info['locations']; ?></h4></div>
</div>
<div class="stat_leaderboard grid-x small-padding-top max-width-1200">
  <?php if(!empty($g365_stat_leader[0][$post_stat_catagory])):/*if-2a*/ foreach($g365_stat_leader[0] as $index => $default_pl_stat):/*foreach-2a*/ ?>
  <div class="small-12 medium-12 large-12">
    <div class="responsive-table">
      <table class="stat-table">
        <?php 
          echo $g365_stat_leader[7];
          foreach($default_pl_stat as $pl_stat):/*foreach-2b*/
          $player_nickname = $pl_stat['player_nickname']; 
          $player_id = $pl_stat['player_id'];
          $event_nickname = $pl_stat['event_nickname'];
          $fav_data = tscircuit_g365_data_xfer(['db_tb'=>'favorites', 'qn_type'=>1, 'player_id'=>$player_id, 'user_id'=>get_current_user_id()], 'SELECT');
          if(($pl_stat['is_fav'] === 'true')){$fav_icon='⭐️';}else{$fav_icon='<a href="#" class="btn-flip" data-back="⭐️" data-front="✩"></a>';}
        ?>
        <tr>
          <td>
            <div class="flex item-center">
              <div class="fav-btn small-padding-right">
                <span style="font-size:20px;cursor:pointer" href="" data-select-id="<?php echo $player_id; ?>" id="<?php echo $player_id; ?>" data-toggle="pl_<?php echo $player_id; ?>"><?php echo $fav_icon; ?></span>
              </div>
              <div>
                <a class="flex align-middle" href="<?php echo $pl_stat['player_profile']; ?>" target="_blank">
                  <div class="small-padding-right">
                    <figure>
                      <div class="image-wrapper">
                        <img alt="<?php echo $pl_stat['player_nickname']; ?>" title="<?php echo $pl_stat['player_name']; ?>" data-mptype="image" src="<?php echo $pl_stat['player_img']; ?>" class="rounded">
                      </div>
                    </figure>
                  </div><?php echo $pl_stat['player_name']; ?>
                </a>
              </div>
            </div>
          </td>
          <td class="text-left small-padding-right"><?php echo !empty($pl_stat['player_division']) ? $pl_stat['player_division'] : '-'; ?></td>
          <td class="text-left small-padding-right"><?php echo !empty($g365_stat_leader[1][$pl_stat['player_level']]) ? $g365_stat_leader[1][$pl_stat['player_level']] : '-'; ?></td>
          <td class="text-left small-padding-right"><?php echo !empty($pl_stat[$index]) ? $pl_stat[$index] : '0'; ?></td>
        </tr>
        <?php echo fav_reveal(['data_toggle'=>'pl_'.$player_id, 'full_name'=>$pl_stat['player_name'], 'pl_nickname'=>$pl_stat['player_nickname'], 'data_note'=>'note_'.$player_id, 'fav_data'=>$fav_data, 'pl_id'=>$player_id, 'pl_img'=>$pl_stat['player_img'], 'pl_grad_year'=>$pl_stat['pl_grad_year'], 'pl_position'=>$pl_stat['pl_position'], 'pl_height'=>$pl_stat['pl_height'], 'pl_gpa'=>$pl_stat['pl_gpa'], 'pl_sat'=>$pl_stat['pl_sat'], 'pl_contact_info'=>$pl_stat['pl_contact_info']], 'add_fav'); endforeach;/*endforeach-2b*/ ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php echo ajax_data_xfer(['class_name'=>'fav_pl'], 'add_fav'); endforeach;/*endforeach-2a*/ else:/*else-2a*/ ?>
    <h3 class="text-center small-padding small-12 medium-12 large-12"><?php echo $g365_stat_leader[5]; ?></h3>
  <?php endif;/*endif-2b*/ ?>
</div>
<script>
  function fav_icon_animation(el){
    var id = el.dataset.plId;
    $("#"+id+" a").addClass("fav_animation");
    $("#"+id+" a").removeClass("btn-flip");
  }
</script>
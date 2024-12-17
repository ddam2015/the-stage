<div class="medium-padding main_fav">
  <h3>Favorite Players' List</h3>
  <?php $player_data = tscircuit_g365_data_xfer(['db_tb'=>'favorites', 'qn_type'=>1, 'user_id'=>get_current_user_id()], 'SELECT'); if(!empty($player_data)): foreach($player_data as $pl_data): $pl_id = $pl_data['player_id']; $pl_note = json_decode($pl_data['notes'], true); $pl_data_fields = json_decode($pl_data['pl_data'], true); $rec_id = $pl_data['id']; ?>
    <div class="grid-x home_fav_box" id="<?php echo $rec_id ?>">
      <div class="small-6 medium-6 large-1 rm_fav" data-toggle="rm_<?php echo $rec_id ?>" data-rm-id="<?php echo $rec_id ?>" >
        <a class="rm_btn" href="#" role="button">
          <span>remove</span>
          <div class="rm_icon">
            <i class="rm_x fa fa-remove">X</i>
            <i class="rm_x fa fa-check">X</i>
          </div>
        </a>
      </div>
      <div class="small-6 medium-6 large-4 flex text-center">
        <div class="cell" data-alphabet="A">
          <a class="emphasis watchlist__player" href="https://grassroots365.com/player/<?php echo $pl_data_fields['pl_nickname']; ?>" target="_blank">
              <img class="watchlist__player-img small-margin-bottom" loading="lazy" data-src="<?php echo $pl_data_fields['img_link']; ?>" alt="Player headshot for <?php echo $pl_data_fields['pl_name']; ?>" src="<?php echo $pl_data_fields['img_link']; ?>"><br>
              <p><?php echo $pl_data_fields['pl_name']; ?></p>
          </a>
        </div>
      </div>
      <div class="small-12 medium-12 large-3">
        <?php echo cdp_fav_pl_info(['pl_name'=>$pl_data_fields['pl_name'], 'grad_year'=>$pl_data_fields['grad_year'], 'position'=>$pl_data_fields['position'], 'height'=>$pl_data_fields['height'], 'gpa'=>$pl_data_fields['gpa'], 'sat'=>$pl_data_fields['sat'], 'contact_info'=>$pl_data_fields['contact_info']], 'pl_fav'); ?>
      </div>
      <div class="small-12 medium-12 large-3">
        <div class="small-12 medium-12 large-12"><a href="">Link to Passport</a></div>
      </div>
      <div class="small-12 medium-12 large-12 fav_note"><h5>Notes: <?php echo $pl_note['notes']; ?></h5>
        <i class="edit_note fi-pencil text-right" data-pl-id="<?php echo $pl_id?>"></i>
      </div>
    </div>
  <?php echo fav_reveal(['rec_id'=>$rec_id, 'data_toggle'=>'rm_'.$rec_id, 'full_name'=>$pl_data_fields['pl_name']], 'remove_fav'); endforeach; else: echo ("<p>No player is added to the favorite list</p>"); endif; echo ajax_data_xfer(['class_name'=>'rm_pl'], 'remove_fav'); ?>
</div>
<script>
  (function() {
    var removeSuccess;
    removeSuccess = function() {
      return $('.rm_btn').removeClass('success');
    };
    $(document).ready(function() {
      return $('.rm_btn').click(function() {
        $(this).addClass('success');
        return setTimeout(removeSuccess, 3000);
      });
    })
  }).call(this);
</script>
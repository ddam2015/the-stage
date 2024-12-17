<?php

function custom_rewrite_rule() {
	add_rewrite_rule('^ownership-registration/?','wp-admin/admin-ajax.php?action=g365_data_receiver','top');
	add_rewrite_rule('^send-claim/?','wp-admin/admin-ajax.php?action=g365_send_claim_notice','top');
	add_rewrite_rule('^register/([^/]*)/?([^/]*)?/?','index.php?page_id=201&rg_tp=$matches[1]&rg_ps=$matches[2]','top');
  add_rewrite_rule('^stat-leaderboard/([^/]*)/?','index.php?page_id=312&pg_type=$matches[1]','top');
//   add_rewrite_rule('^tournament-awards/([^/]*)/?([^/]*)?/?','index.php?page_id=334&pg_type=$matches[1]&aw_id=$matches[2]','top');
	add_rewrite_rule('^tournament-awards/([^/]*)/?([^/]*)?/?','index.php?page_id=334&aw_id=$matches[1]&aw_tm=$matches[2]','top');
}
add_action('init', 'custom_rewrite_rule', 10, 0);

//custom page url rewrites
function custom_rewrite_tag() {
  add_rewrite_tag('%rg_tp%', '([^&]+)');
  add_rewrite_tag('%rg_ps%', '([^&]+)');
  add_rewrite_tag('%pg_type%', '([^&]+)');
  add_rewrite_tag('%aw_id%', '([^&]+)');
  add_rewrite_tag('%aw_tm%', '([^&]+)');
}
add_action('init', 'custom_rewrite_tag', 10, 0);

/*
 * load required files
 */
get_template_part( 'inc/cleanup' );
get_template_part( 'inc/menu-cache' );
get_template_part( 'inc/menu-walkers' );
get_template_part( 'inc/gallery' );
get_template_part( 'inc/g365_conn' );
get_template_part( 'inc/general' );
get_template_part( 'inc/woocomm' );
get_template_part( 'inc/woocomm-gatekeep' );

add_role( 'gate_controller', 'Gatekeeper', array( 'read' => true ) );

?>
<?php
//global G365 type keys
function g365_return_keys( $key_type ) {
  switch( $key_type ) {
    case 'findus_options_key':
      return array(
        ''          => 'Please select',
        'friend'    => 'A friend',
        'google'    => 'Google',
        'o_website' => 'Our Website',
        'grpon'     => 'Groupon',
        'lnkdin'    => 'LinkedIn',
        'instag'    => 'Instagram',
        'faceb'     => 'Facebook',
        'twitt'     => 'Twitter',
        'indeed'    => 'Indeed',
        'walk_in'   => 'Walk-In'
      );
      break;
    case 'g365_cat_form_key': //[0] data_type for category, [1] data_target for management
      return array(array(
        'tournaments' => 'rosters_event',
        'camps' => 'camps',
        'player-membership' => 'pl_ev',
        'club-teams' => 'club_team',
        'training' => 'club_team',
        'leagues' => 'club_team'
      ),array(
        'tournaments' => 'event_id',
        'camps' => 'event_id_cp',
        'player-membership' => 'event_id_pm',
        'club-teams' => 'event_id_ct',
        'training' => 'event_id_ct',
        'leagues' => 'event_id_ct'
      ));
      break;
    case 'g365_url_form_key': //[0] data_type for url, [1] data_target for management
      return array(array(
        'tournaments' => 'rosters_teams',
        'camps' => 'player_event',
        'player-certification' => 'pl_cert_sl',
        'club-teams' => 'rosters_teams',
        'training' => 'player_event',
        'leagues' => 'player_event',
        'college-placement' => 'player_event',
        'coaches' => 'coach_names',
        'rosters' => 'rosters'
      ),array(
        'tournaments' => 'event_id',
        'camps' => 'event_id_cp',
        'player-certification' => 'event_id_pm',
        'club-teams' => 'event_id',
        'training' => 'event_id_pm',
        'leagues' => 'event_id_pm',
        'college-placement' => 'event_id_pm',
        'coaches' => 'coach_id',
        'rosters' => 'event_id'
      ));
      break;
    case 'g365_grade_key_short':
      return array(
        8 => "8U",
        9 => "9U",
        10 => "10U",
        11 => "11U",
        12 => "12U",
        13 => "13U",
        14 => "14U",
        15 => "15U",
        16 => "16U",
        17 => "17U"
      );
      break;
    case 'g365_grade_key':
      return array(
        8 => "8U/2nd Grade",
        9 => "9U/3rd Grade",
        10 => "10U/4th Grade",
        11 => "11U/5th Grade",
        12 => "12U/6th Grade",
        13 => "13U/7th Grade",
        14 => "14U/8th Grade",
        15 => "15U/Frosoph",
        16 => "16U/JV",
        17 => "17U/Varsity"
      );
      break;
  }
}

//ninja forms
//add user data to submission table in admin 
function pl_waiver_columns( $columns ) {
  //get rid of the submission number and the liability checkbox
  unset( $columns['seq_num'] );
  unset( $columns['30'] );
  //add user name and email
  $columns['tscircuit_user_name'] = 'User Name';
  $columns['tscircuit_user_email'] = 'User Email';
  return $columns;
}
add_filter( 'manage_nf_sub_posts_columns', 'pl_waiver_columns' );

function pl_waiver_column( $column, $sub_id ) {
  if( $column === 'tscircuit_user_name' || $column === 'tscircuit_user_email' ) {
    //get submission data
    $sub = Ninja_Forms()->form()->get_sub( $sub_id );
    //pull user info
    $user = $sub->get_user();
    //add it in to the column data
    if( $column === 'tscircuit_user_name') echo $user->data->user_nicename;
    if( $column === 'tscircuit_user_email') echo $user->data->user_email;
  }
}
add_action( 'manage_nf_sub_posts_custom_column', 'pl_waiver_column', 11, 2 );


//remove all css
function remove_nf_enqueue_scripts(){
    wp_dequeue_style( 'nf-display' );
}
add_action( 'nf_display_enqueue_scripts', 'remove_nf_enqueue_scripts');

// remove comment  rss links from pages
function remove_unnecessary_rss_links( ){
	if( is_page() ){
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'feed_links_extra', 3);
	}
}
add_action( 'wp', 'remove_unnecessary_rss_links', 0 );

// add page content rss back, since we can only remove all feeds @remove_unecessary_rss_links
function add_content_rss_feed_link_to_pages( ){
	if( is_page() ){
		 echo '<link rel="alternate" type="' . feed_content_type() . '" title="' . 
		 esc_attr( sprintf( __('%1$s %2$s Feed'), get_bloginfo('name'), "|") ) . '" href="' . 
		 esc_url( get_feed_link() ) . "\" />\n";
    }
}
add_action( 'wp_head', 'add_content_rss_feed_link_to_pages', 3 );

// don't load images or admin assets in
function load_404_template_for_images(){
	if( ! is_attachment() || is_admin() )
		return;
		
	global $wp_query;
	$wp_query->set_404();
	header( 'HTTP/1.0 404 Not Found' );
	
}
add_filter( 'wp', 'load_404_template_for_images', 1 );


/**
 * Remove height and width from featured images
 */
function featured_image_process( $html ) {
  return preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
}
add_filter( 'post_thumbnail_html', 'featured_image_process' );


/**
 * Add the id for the 
 */
add_filter('clean_url','mod_clean_url',10,3);
function mod_clean_url( $good_protocol_url, $original_url, $_context){
//     if (false !== strpos($original_url, 'data-processor.js') || false !== strpos($original_url, 'js/app.js') || false !== strpos($original_url, 'js/app-admin.js')){
    if (false !== strpos($original_url, 'data-processor.js')){
      remove_filter('clean_url','mod_clean_url',10,3);
      $url_parts = parse_url($good_protocol_url);
      return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . "' id='g365_form_script";
    }
    return $good_protocol_url;
}

/**
 * Enqueue scripts and styles
 */
function theme_scripts() {
	
	if( is_admin() )
		return;
	
	wp_enqueue_style( 'font-all', '//fonts.googleapis.com/css?family=Montserrat:400,400i,600|News+Cycle:400,700' );
	wp_enqueue_style( 'foundation-all', get_template_directory_uri() . "/css/style.css?ver=3.2" );
	
	wp_deregister_script('jquery');
	wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', array(), '2.2.4', true );
	wp_enqueue_script( 'foundation', '//cdn.jsdelivr.net/npm/foundation-sites@6.5.1/dist/js/foundation.min.js', array('jquery'), '69548', true );
  wp_enqueue_script( 'js-all', get_template_directory_uri() . '/js/app.js', array('jquery','foundation'), '34061', true );
  wp_enqueue_script( 'inc-custom', get_template_directory_uri() . '/js/inc/custom.js', array('jquery','foundation'), '1.1', true );

}
add_action( 'wp_enqueue_scripts', 'theme_scripts');

/*
* favicons
*/
function add_apple_touch_icons(){
	echo '<meta name="HandheldFriendly" content="true" />'. "\n";
	echo '<meta name="MobileOptimized" content="width" />'. "\n";
	echo '<link rel="apple-touch-icon-precomposed" href="' . get_template_directory_uri() . '/assets/icon-57x57.png" />' . "\n";
	echo '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . get_template_directory_uri() . '/assets/icon-72x72.png" />' . "\n";
	echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . get_template_directory_uri() . '/assets/icon-114x114.png" />' . "\n";
	echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . get_template_directory_uri() . '/assets/icon-144x144.png" />' . "\n";
	echo '<link rel="icon" type="image/png" href="' . get_template_directory_uri() . '/assets/tiny-logos/The-Stage-Logo-tiny.png" />' . "\n";
  
}
add_action('wp_head', 'add_apple_touch_icons', 1);

/**
 * Setup theme support
 */
if ( ! function_exists( 'theme_setup' ) ) :
	function theme_setup() {
		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
    add_theme_support( 'align-wide' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'quote' ) );

		load_theme_textdomain( 'tscircuit-press' );
		add_image_size( 'featured-home', 900, 420, true );
    add_image_size('medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true );
    add_image_size('large', get_option( 'large_size_w' ), get_option( 'large_size_h' ), true );

		register_nav_menus( array(
			'title_nav' => 'Title Navigation Bar',
			'main_nav' => 'Main Navigation Bar',
			'footer_nav' => 'Footer Navigation List'
			)
		);
	}
endif; // theme_setup
add_action( 'after_setup_theme', 'theme_setup', 5 );

//function to output data to error log
function var_error_log( $object=null ){
    ob_start();                    // start buffer capture
    var_dump( $object );           // dump the values
    $contents = ob_get_contents(); // put the buffer into a variable
    ob_end_clean();                // end capture
    error_log( $contents );        // log contents of the result of var_dump( $object )
}

//down sample any uploaded images to a maximum size
function upload_image_limiter ( $params )
{
    $filePath = $params['file'];
  
    if ( (!is_wp_error($params)) && file_exists($filePath) && in_array($params['type'], array('image/png','image/gif','image/jpeg','image/jpg')))
    {
        $image = wp_get_image_editor( $filePath );
        if ( ! is_wp_error( $image ) ) {
          ( is_admin() ) ? $image->resize( 2400, 1200 ) : $image->resize( 1200, 1000 );
          $image->save( $filePath );
        }
        else
        {
            $params = wp_handle_upload_error
            (
                $filePath,
                $image->get_error_message() 
            );
        }
    }

    return $params;
}
add_filter( 'wp_handle_upload', 'upload_image_limiter' );

// Main Navigation w/ Drawers
if ( ! function_exists( 'tscircuit_main_nav' ) ) {
	function tscircuit_main_nav() {
    function mobile_menu_support($classes, $item, $args) {
      $classes[] = ( in_array('non-mobile', $classes) ) ? 'hide' : 'hide-for-medium';
      return $classes;
    }
    add_filter('nav_menu_css_class', 'mobile_menu_support', 1, 3);
    $title_menu_for_mobile = wp_nav_menu( array(
			'theme_location' => 'title_nav',
			'container'      => false,
			'items_wrap'     => '%3$s',
      'echo'           => false
		));
    remove_filter('nav_menu_css_class', 'mobile_menu_support', 1 );

    wp_nav_menu( array(
			'theme_location' => 'main_nav',
			'container'      => false,
			'menu_class'     => 'dropdown menu medium-horizontal align-center menu-drawer',
			'items_wrap'     => '<ul id="main-nav" class="%2$s" data-dropdown-menu>' . $title_menu_for_mobile . '%3$s</ul>',
			'fallback_cb'    => false,
			'walker'         => new tscircuit_Top_Bar_Walker()
		));
	}
}
// Main Navigation Mega
if ( ! function_exists( 'tscircuit_mega_nav' ) ) {
	function tscircuit_mega_nav() {
		wp_nav_menu( array(
			'theme_location' => 'main_nav',
			'container'      => false,
			'menu_class'     => 'menu grid-x grid-margin-x menu-mega',
			'items_wrap'     => '<ul id="main-nav" class="%2$s">%3$s</ul>',
			'fallback_cb'    => false,
			'walker'         => new tscircuit_Mega_Walker()
		));
	}
}
// Main Navigation side Slide
if ( ! function_exists( 'tscircuit_side_slide_nav' ) ) {
	function tscircuit_side_slide_nav() {
		wp_nav_menu( array(
			'theme_location' => 'main_nav',
			'container'      => false,
			'menu_class'     => 'vertical dropdown menu',
			'items_wrap'     => '<ul id="main-nav" class="%2$s" data-dropdown-menu data-click-open="true" data-disable-hover="true">%3$s</ul>',
			'fallback_cb'    => false,
			'walker'         => new tscircuit_Side_Slide_Walker()
		));
	}
}
// Title Nav
if ( ! function_exists( 'tscircuit_title_nav' ) ) {
	function tscircuit_title_nav() {
		wp_nav_menu( array(
			'theme_location' => 'title_nav',
			'container'      => false,
			'menu_class'     => 'title-nav dropdown menu horizontal align-right',
			'items_wrap'     => '<ul id="title-nav" class="%2$s" data-dropdown-menu>%3$s</ul>',
			'fallback_cb'    => false
		));
	}
}
// Footer Nav
if ( ! function_exists( 'tscircuit_footer_nav' ) ) {
	function tscircuit_footer_nav() {
		wp_nav_menu( array(
			'theme_location' => 'footer_nav',
			'container'      => false,
			'menu_class'     => 'menu vertical medium-horizontal align-center text-center',
			'items_wrap'     => '<ul id="footer-nav" class="%2$s">%3$s</ul>',
			'fallback_cb'    => false,
			'walker'         => new tscircuit_Top_Bar_Walker()
		));
	}
}


/**
 * Add support for buttons in the top-bar menu:
 * 1) In WordPress admin, go to Apperance -> Menus.
 * 2) Click 'Screen Options' from the top panel and enable 'CSS CLasses' and 'Link Relationship (XFN)'
 * 3) On your menu item, type 'has-form' in the CSS-classes field. Type 'button' in the XFN field
 * 4) Save Menu. Your menu item will now appear as a button in your top-menu
*/
if ( ! function_exists( 'add_menuclass' ) ) {
	function add_menuclass( $ulclass ) {
		$find = array('/<a rel="button"/', '/<a title=".*?" rel="button"/');
		$replace = array('<a rel="button" class="button"', '<a rel="button" class="button"');

		return preg_replace( $find, $replace, $ulclass, 1 );
	}
	add_filter( 'wp_nav_menu','add_menuclass' );
}

if ( ! function_exists( 'tscircuit_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 * Wraps the excerpt in a div element.
	 * Create your own tscircuit_excerpt() function to override in a child theme.
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function tscircuit_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) :
      if( strpos($class, 'title_insert') === false ) : ?>
        <div class="<?php echo $class; ?>">
          <?php the_excerpt(); ?>
        </div><!-- .<?php echo $class; ?> -->
		<?php else :
      return ' <small class="' . $class . '">' . get_the_excerpt() . '</small>';
      endif;
    endif;
	}
endif;

if ( ! function_exists( 'tscircuit_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 * Create your own tscircuit_excerpt_more() function to override in a child theme.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function tscircuit_excerpt_more() {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'tscircuit-press' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'tscircuit_excerpt_more' );
endif;

if ( ! function_exists( 'tscircuit_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 * Create your own tscircuit_entry_meta() function to override in a child theme.
 */
function tscircuit_entry_meta() {
	if ( 'posts' === get_post_type() ) {
		$author_avatar_size = apply_filters( 'tscircuit_author_avatar_size', 49 );
		printf( '<span class="byline"><span class="author vcard">%1$s <span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
			get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
			_x( 'Author', 'Used before post author name.', 'tscircuit-press' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		tscircuit_entry_date();
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'tscircuit-press' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( 'posts' === get_post_type() ) {
// 		tscircuit_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'tscircuit-press' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'tscircuit_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 * Create your own tscircuit_entry_date() function to override in a child theme.
 */
function tscircuit_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
// 		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> | <time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'tscircuit-press' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

function post_type_content($page_name, $print = true, $post_type = 'page' ) {
	$page = get_page_by_title( $page_name, 'OBJECT', $post_type );
	$page = ( $page !== null ) ? $page->post_content : null;
	if( !empty($page) ) {
		if( $print ){
			echo apply_filters('the_content', $page);
		} else {
			return apply_filters('the_content', $page);
		}
	} else {
		return null;
	}
}

function foundation_content($content) {
	if( strpos(trim($content), '<div class="grid-x') === 0 ){
		return $content;
	} else {
    $return_string = '<div class="grid-x">';
    if( strpos(trim($content), '<div class="cell') === 0 ) {
      $return_string .= $content;
    } else {
      $return_string .= '<div class="cell small-12">' . $content . '</div>';
    }
    $return_string .= '</div>';
		return $return_string;
	}
} 
add_filter('the_content', 'foundation_content');

//admin page functions


//add options to admin menu
function tscircuit_admin_menu() {
	add_menu_page( 'OGP Data Admin', 'Data', 'manage_options', 'tscircuit_data', 'tscircuit_admin', 'dashicons-chart-line', 26  );
// 	add_submenu_page( 'tscircuit_data', 'tscircuit Data Dashboard', 'Dashboard', 'manage_options', 'tscircuit_data', 'tscircuit_admin' );
}
add_action( 'admin_menu', 'tscircuit_admin_menu' );

//build admin page
function tscircuit_admin(){
	wp_enqueue_style( 'tscircuit_admin_styles', get_stylesheet_directory_uri() . '/css/tscircuit-admin-style.css' );
	$g_action = filter_input( INPUT_GET, 'g_action', FILTER_SANITIZE_URL );
	$g_action = ( empty($g_action) ) ? 'settings' : $g_action;
	$tscircuit_sections = array(
		'settings' => array(
			'title'		=> 'Manage Site Settings',
			'tab_name'	=> 'Settings',
			'url'			=> '?page=tscircuit_data&g_action=settings'
		)
	);
	echo '<div class="tscircuit_data_manager_wrapper">';
	$tscircuit_admin_url = '';
	$nav = '';
	foreach( $tscircuit_sections as $section => $section_data ) {
		if( $section == $g_action ) {
			echo '<h1>' . $section_data['title'] . '</h1>';
			$tscircuit_admin_url = $section_data['url'];
			$nav .= '<a href="' . $section_data['url'] . '" class="nav-tab nav-tab-active">' . $section_data['tab_name'] . '</a>';
		} else {
			$nav .= '<a href="' . $section_data['url'] . '" class="nav-tab">' . $section_data['tab_name'] . '</a>';
		}
	}
	echo '<nav class="nav-tab-wrapper">' . $nav . '</nav><div class="tscircuit_data_manager_content_wrapper">';
	switch( $g_action ) {
		case 'export_data':
			tscircuit_export();
			break;
		case 'record_data':
			tscircuit_record_stats(); 
			break;
		case 'settings':
			$tscircuit_admin_settings = array(
				'display' => array(
					'section_title'		=> 'Global Ads',
					'section_records'	=> array(
						'site_1' => array(
							'title' => 'Premier Global Ad',
							'description'=> 'First global ad to appear, second in over all rotation.',
							'items' => array(
								'title' => array(
									'element_type' => 'input',
									'title' => 'Ad Meta Title',
									'description'=> 'Less than 100 characters.',
									'type' => 'text',
									'limits' => 'maxlength="100"',
									'data' => '',
									'value' => ''
								),
								'link' => array(
									'element_type' => 'input',
									'title' => 'Ad Link',
									'description'=> 'Less than 200 characters. Absolute link.',
									'type' => 'url',
									'limits' => 'maxlength="200"',
									'data' => '',
									'value' => ''
								),
								'img' => array(
									'element_type' => 'input',
									'title' => 'Ad Graphic',
									'description'=> 'Must be exactly 1200px X 150px.',
									'type' => 'url',
									'limits' => 'maxlength="200"',
									'data' => '',
									'value' => ''
								)
							)
						),
						'site_2' => array(
							'title' => 'Secondary Global Ad',
							'description'=> 'Second global ad to appear, fourth in over all rotation.',
							'items' => array(
								'title' => array(
									'element_type' => 'input',
									'title' => 'Ad Meta Title',
									'description'=> 'Less than 100 characters.',
									'type' => 'text',
									'limits' => 'maxlength="100"',
									'data' => '',
									'value' => ''
								),
								'link' => array(
									'element_type' => 'input',
									'title' => 'Ad Link',
									'description'=> 'Less than 200 characters. Absolute link.',
									'type' => 'url',
									'limits' => 'maxlength="200"',
									'data' => '',
									'value' => ''
								),
								'img' => array(
									'element_type' => 'input',
									'title' => 'Ad Graphic',
									'description'=> 'Must be exactly 1200px X 150px.',
									'type' => 'url',
									'limits' => 'maxlength="200"',
									'data' => '',
									'value' => ''
								)
							)
						),
						'site_3' => array(
							'title' => 'Splash Homepage Ad',
							'description'=> 'Appears above homepage, and has to be interacted with to pass.',
							'items' => array(
								'title' => array(
									'element_type' => 'input',
									'title' => 'Ad Meta Title',
									'description'=> 'Less than 100 characters.',
									'type' => 'text',
									'limits' => 'maxlength="100"',
									'data' => '',
									'value' => ''
								),
								'link' => array(
									'element_type' => 'input',
									'title' => 'Ad Link',
									'description'=> 'Less than 200 characters. Absolute link.',
									'type' => 'url',
									'limits' => 'maxlength="200"',
									'data' => '',
									'value' => ''
								),
								'img' => array(
									'element_type' => 'input',
									'title' => 'Ad Graphic',
									'description'=> 'Must be smaller than 1200px X 600px.',
									'type' => 'url',
									'limits' => 'maxlength="200"',
									'data' => '',
									'value' => ''
								),
								'img_mobile' => array(
									'element_type' => 'input',
									'title' => 'Ad Mobile Graphic',
									'description'=> 'Displays below 600px. Must be between 600px X 600px-1200px.',
									'type' => 'url',
									'limits' => 'maxlength="200"',
									'data' => '',
									'value' => ''
								),
								'description' => array(
									'element_type' => 'input',
									'title' => 'Ad Description',
									'description'=> 'Less than 150 characters.',
									'type' => 'text',
									'limits' => 'maxlength="150"',
									'data' => '',
									'value' => ''
								)
							)
						),
						'site_4' => array(
							'title' => 'Homepage ',
							'description'=> 'Appears as a banner in the middle of the tiles in the Tiled Homepage Layout.',
							'items' => array(
								'title' => array(
									'element_type' => 'input',
									'title' => 'Featured Banner Title',
									'description'=> 'Less than 50 characters.',
									'type' => 'text',
									'limits' => 'maxlength="50"',
									'data' => '',
									'value' => ''
								),
								'sub_title' => array(
									'element_type' => 'input',
									'title' => 'Banner Tile Sub Header',
									'description'=> 'Less than 200 characters.',
									'type' => 'text',
									'limits' => 'maxlength="200"',
									'data' => '',
									'value' => ''
								),
								'link' => array(
									'element_type' => 'input',
									'title' => 'Banner Tile Link',
									'description'=> 'Less than 200 characters. Absolute link.',
									'type' => 'url',
									'limits' => 'maxlength="200"',
									'data' => '',
									'value' => ''
								)
							)
						)
					)
				),
				'layout' => array(
					'section_title'		=> 'Global Layouts',
					'section_records'	=> array(
						'front_layout' => array(
							'title' => 'Homepage Layout',
							'description'=> 'Switch between featured posts layouts',
							'items' => array(
								'type' => array(
									'element_type' => 'radio',
									'title' => 'Featured Layout',
									'description'=> 'Choose one.',
									'type' => 'radio',
									'chosen' => 'checked',
									'value' => 'news',
                  'options' => array(
                    array( 'option_name' => 'News Slider', 'option' => 'news' ),
                    array( 'option_name' => 'Large Tiles', 'option' => 'tiles' )
                  )
								)
							)
						),
						'menu_layout' => array(
							'title' => 'Menu Layout',
							'description'=> 'Switch between menu styles',
							'items' => array(
								'type' => array(
									'element_type' => 'radio',
									'title' => 'Menu Type',
									'description'=> 'Choose one.',
									'type' => 'radio',
									'chosen' => 'checked',
									'value' => 'drawer',
                  'options' => array(
                    array( 'option_name' => 'Traditional Menu', 'option' => 'drawer' ),
                    array( 'option_name' => 'Mega Menu', 'option' => 'mega' ),
                    array( 'option_name' => 'Side Slide Menu', 'option' => 'side_slide' )
                  )
								)
							)
						)
          )
				),
				'g365_connector' => array(
					'section_title'		=> 'Grassroots 365 Connection',
					'section_records'	=> array(
						'connector_data' => array(
							'title' => 'Grassroots 365 API Keys',
							'description'=> 'Add keys to enable Grassroots 365 functionality',
							'items' => array(
								'trans_key' => array(
									'element_type' => 'input',
									'title' => 'Transaction Key',
									'description'=> 'Copy from Grassroots 365 account.',
									'type' => 'text',
									'limits' => 'maxlength="34"',
									'data' => '',
									'value' => ''
								),
								'trans_id' => array(
									'element_type' => 'input',
									'title' => 'Transaction ID',
									'description'=> 'Copy from Grassroots 365 account.',
									'type' => 'text',
									'limits' => 'maxlength="29"',
									'data' => '',
									'value' => ''
								)
							)
						)
          )
        )
			);
			function tscircuit_update_admin_site_settings( $old, $new ) {
				foreach( $new as $item => $item_data ) {
					foreach( $item_data as $item_name => $item_value ) {
						$old[$item]['items'][$item_name]['value'] = tscircuit_process_data_point( $old[$item]['items'][$item_name]['type'], $item_value);
            if( $old[$item]['items'][$item_name]['value'] === null || $old[$item]['items'][$item_name]['value'] === 'null' ) $old[$item]['items'][$item_name]['value'] = '';
					}
				}
				return $old;
			}
			foreach( $tscircuit_admin_settings as $setting_set => &$setting_data ) {
				if( $_POST['g_process'] == 'process' ) {
					$tscircuit_db_option = $_POST['tscircuit_admin_form_data'][$setting_set];
					$update = update_option( 'tscircuit_' . $setting_set, $tscircuit_db_option );
					$setting_data['section_records'] = tscircuit_update_admin_site_settings( $setting_data['section_records'], $tscircuit_db_option );
					if( $update === true ) echo '<p class="success">Updated settings data!</p>';
				} else {
					$tscircuit_db_option = get_option( 'tscircuit_' . $setting_set );
					if( $tscircuit_db_option !== false && !empty($tscircuit_db_option) ) $setting_data['section_records'] = tscircuit_update_admin_site_settings( $setting_data['section_records'], $tscircuit_db_option );
        }
			} ?>
			<h3>General Site Settings</h3>
			<form id="tscircuit_form" method="post" class="tscircuit_form" action="<?php echo $tscircuit_admin_url; ?>">
				<input type="hidden" name="g_process" value="process" />
			<?php foreach( $tscircuit_admin_settings as $setting_set_re => $setting_data_re ) : ?>
				<h4><?php echo $setting_data_re['section_title']; ?></h4>
				<?php foreach( $setting_data_re['section_records'] as $record => $record_data ) : ?>
				<hr />
				<h5>
					<?php echo $record_data['title']; ?>
					<?php echo ( empty($record_data['description']) ) ? '' : '<small>' . $record_data['description'] . '</small>'; ?>
				</h5>
				<table class="tscircuit_form_section form-table">
					<tbody>
					<?php foreach( $record_data['items'] as $element => $element_data ) {
						$element_data['tag'] = 'tscircuit_admin_form_data[' . $setting_set_re . '][' . $record . '][' . $element . ']';
						$element_data['description'] = ( empty($element_data['description']) ) ? '' : '<small>' . $element_data['description'] . '</small>';
						echo tscircuit_template_construction( $element_data );
					} ?>
					</tbody>
				</table>
				<?php endforeach;
			endforeach; ?>
				<button class="button">Update Settings</button>
			</form>
			<?php break;
		default:
			echo '<h2>Error, this page shouldn\'t be accessible. Please contact your system administrator.</h2>';
	}
	echo '</div></div>';
}

//g365 data converter string to associative array
function g365_data_string_array($data) {
  $data = explode('|', $data);
  $data = array_map( function($section){ return explode(',', $section); }, $data);
  $proc_data_compile = array();
  foreach( $data as $dex => $vals ) $proc_data_compile[array_shift($vals)] = $vals;
  return $proc_data_compile;
}
//g365 reference/owner integrator of the format 'data,id,id,id|data,id,id,id'
function g365_reference_data_integrator( $new_data, $existing ) {
  if( empty($new_data) ) return $existing;
  //parse incoming
  if( is_string($new_data) ) $new_data = g365_data_string_array( $new_data );
  //if there isn't any existing data return what we have
  if( $existing === '' || $existing === null ) return $new_data;
  //parse exisitng data
  if( is_string($exisiting) ) $existing = g365_data_string_array( $existing );
  //integrate the new data into the existing
  foreach( $new_data as $key => $vals ) {
    if( !isset($existing[ $key ]) ) $existing[ $key ] = array();
    $existing[ $key ] = array_unique(array_merge(array_map(function($val_ids){ return intval($val_ids); }, $vals),$existing[ $key ]), SORT_REGULAR);
  }
  return $existing;
}


//add g365 data ownership to user
add_action( 'wp_ajax_nopriv_g365_data_receiver', 'g365_data_receiver' );
add_action( 'wp_ajax_g365_data_receiver', 'g365_data_receiver' );

//use the ajax wordpress pathway to write ownership from g365
function g365_data_receiver(){
  $grassroots_keys = get_option( 'tscircuit_g365_connector' );
  if( empty($grassroots_keys['connector_data']['trans_key'])  || empty($grassroots_keys['connector_data']['trans_id']) ) die('Missing trans keys. Please contact administrator.');
	//what ever data needs to be sent back
  $auth_keys = base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6));
	$data_result = array(
		'status' => 'failed',
		'message'=> ['error' => 'Error with Auth Keys, please contact your G365 Representative.']
	);
  $owner_id = intval($_POST['owner_id']);
  if( $grassroots_keys['connector_data']['trans_key'] === substr($auth_keys, 0, 34) && $grassroots_keys['connector_data']['trans_id'] === substr($auth_keys, -29)  && !empty($_POST['data_own_ref']) && !empty($owner_id) ) {
    //pull and update existing user data
    $data_result['status'] = 'success';
//     $data_result['message'] = g365_reference_data_integrator( $_POST['data_own_ref'], get_user_meta( $owner_id, '_user_owns_g365', true) );
    $data_result['message'] = ( update_user_meta( $owner_id, '_user_owns_g365', g365_reference_data_integrator( $_POST['data_own_ref'], get_user_meta( $owner_id, '_user_owns_g365', true) ) ) === false ) ? 'Failed to update remote.' . $owner_id : 'Successful remote update.' . $owner_id;
  }
  echo json_encode($data_result);
	die();
}

//add data
add_action( 'wp_ajax_nopriv_g365_send_claim_notice', 'g365_send_claim_notice' );
add_action( 'wp_ajax_g365_send_claim_notice', 'g365_send_claim_notice' );

//use the ajax wordpress pathway to manage external data inputs
function g365_send_claim_notice(){
  $grassroots_keys = get_option( 'tscircuit_g365_connector' );
  if( empty($grassroots_keys['connector_data']['trans_key'])  || empty($grassroots_keys['connector_data']['trans_id']) ) die('Missing trans keys. Please contact administrator.');
	//what ever data needs to be sent back
  $auth_keys = base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6));
	$data_result = array(
		'status' => 'failed',
		'message'=> ['error' => 'Error with Auth Keys, please contact your G365 Representative.']
	);
  $owner_id = intval($_POST['data_owner']);
  if( $grassroots_keys['connector_data']['trans_key'] === substr($auth_keys, 0, 34) && $grassroots_keys['connector_data']['trans_id'] === substr($auth_keys, -29)  && !empty($owner_id)  && !empty($_POST['data_name'])  && !empty($_POST['data_requester']) ) {
    //pull existing user data
    $target_user = get_userdata( $owner_id );
    $data_name = sanitize_text_field( $_POST['data_name'] );
    $data_email = sanitize_email( $_POST['data_requester'] );
    $data_ref_id = intval( $_POST['data_ref_id'] );
    //email variables
    $subject = 'Access request for ' . $data_name;
    $message = "<p>You are the owner of the " . $data_name . " Profile on Grassroots365.<br>";
    $message .= 'There is a request for permission to share access to this profile data from ' . $data_email . '<br>';
    $message .= "If you don't recognize the requester please disregard this notice.</p>";
    $message .= '<p><a href="' . site_url() . '/register/claim-confirmations/?ref_id=' . $data_ref_id . '&ref_em=' . $data_email . '" style="background:#000;color:#fff;border-radius:10px;padding:10px 20px;font-size:1.25rem;text-decoration:none;">Please click here to grant access</a></p>';
    //send email
    $send_result = send_html_email( $target_user->user_email, $subject, $message );
    if( $send_result ) {
      $data_result['status'] = 'success';
      $data_result['message'] = ' Request successfully sent to owner.';
    } else {
      $data_result['message'] = ' Request not sent.';
    }
  }
  echo json_encode($data_result);
	die();
}

function g365_authorize_claim( $id, $email ){
  $current_user = wp_get_current_user();
  $target_user = get_user_by( 'email', sanitize_email($email) );
  if( $target_user === false || $current_user === false ) return array('message' => 'Cannot find both users.');
//   $admin_key = g365_make_admin_key();
  $claim_auth_result = g365_conn( 'g365_authorize_claim', [$id, $current_user->ID, $target_user->ID] );
  //if we have a proper response, the status was successful, and the users match... finish up
  if( is_object($claim_auth_result) && $claim_auth_result->status === 2 && $claim_auth_result->target_user === $target_user->user_email ) {
    $user_update = ( update_user_meta( $target_user->ID, '_user_owns_g365', g365_reference_data_integrator( $claim_auth_result->access_id, get_user_meta( $target_user->ID, '_user_owns_g365', true) ) ) === false ) ?  'Failed to update user access.' : 'Successful user access update.';
    $claim_auth_result->message .= ' ' . $user_update;
    if( $user_update === 'Successful user access update.' ) $claim_auth_result->message .= ' ' . g365_conn( 'g365_authorize_claim', [$id, $current_user->ID, $target_user->ID, true] )[0];
    return $claim_auth_result->message;
  }
  return $claim_auth_result;
}

//send an email with html content
function send_html_email($email, $subject, $message) {
  $headers = ( strpos( site_url(), 'dev' ) !== false ) ? array('From: tscircuit Dev Customer Service <no-reply@dev.elitebasketballcircuit.com>') : array('From: tscircuit Customer Service <no-reply@elitebasketballcircuit.com>');
  add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
  $email_status = wp_mail( $email, $subject, $message, $headers );
  remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
  return $email_status;
}


//purge cps pp page
add_action( 'wp_ajax_nopriv_cps_pp_cache_purge', 'cps_pp_cache_purge' );
add_action( 'wp_ajax_cps_pp_cache_purge', 'cps_pp_cache_purge' );

//use the ajax wordpress pathway to manage external data inputs
function cps_pp_cache_purge(){
  $status = 'WP Super Cache not active';
  if ( is_plugin_active('wp-super-cache/wp-cache.php') ) {
    wpsc_delete_post_cache( 3038 ); //2561
    $status = 'Profiles page cache purged';
  }
  echo $status;
	die();
}

//serve ads when needed

function tscircuit_start_ads( $pageID ){
// 	$pageID = ( $pageID === null ) ? $post->ID : $pageID;
	//see if we have any ads on this page
	$tscircuit_page_ad = array(
		'title'	=> get_post_meta($pageID, 'ad_title', true),
		'link'	=> get_post_meta($pageID, 'ad_link', true),
		'img'		=> get_post_meta($pageID, 'ad_img', true),
		'element_type'	=> 'rotator'
	);
	//get site global ad settings
	$tscircuit_site_ads = get_option( 'tscircuit_display' );
	//if the page doesn't have an ad or the site global is empty, don't add to array
	$ad_info['go'] = ( empty($tscircuit_page_ad['link']) || empty($tscircuit_page_ad['img']) || empty($tscircuit_site_ads) ) ? false : true;
	//general header banner ads GOOOO!
	if ( $ad_info['go'] ) {
		$ad_info = array(
			'go' => true,
			'ad_section_class'	=> ' no-padding-top',
			'ad_before'	=> '<div id="event_display_rotator" class="slick display-wrapper small-small-margin-bottom large-margin-bottom" role="region" aria-label="Upcoming Events">',
			'ad_content'	=> '',
			'ad_after'	=> '</div>'
		);
		//future functionality, ad treatment type
		$tscircuit_site_ads['site_1']['element_type'] = 'rotator';
		$tscircuit_site_ads['site_2']['element_type'] = 'rotator';
		//build rotator element for page ad
		$ad_info['ad_content'] .= tscircuit_template_construction( $tscircuit_page_ad );
		//if we have a global ad, build and add it
		if( !empty($tscircuit_site_ads['site_1']['img']) ) $ad_info['ad_content'] .= tscircuit_template_construction( $tscircuit_site_ads['site_1'] );
		//if we have a secondary global ad, build if and add it along with another primary ad to help the flow
		if( !empty($tscircuit_site_ads['site_2']['img']) ) {
			$ad_info['ad_content'] .= tscircuit_template_construction( $tscircuit_page_ad );
			$ad_info['ad_content'] .= tscircuit_template_construction( $tscircuit_site_ads['site_2'] );
		}
	}
	//on the front page, and if we have a global splash setting
	if( is_front_page() && !empty($tscircuit_site_ads['site_3']) ) {
		//controls for the splash
		$tscircuit_splash = array(
			'title'				=> ( empty($tscircuit_site_ads['site_3']['title']) ) ? '' : $tscircuit_site_ads['site_3']['title'],
			'link'				=> ( empty($tscircuit_site_ads['site_3']['link']) ) ? '' : $tscircuit_site_ads['site_3']['link'],
			'img'					=> ( empty($tscircuit_site_ads['site_3']['img']) ) ? '' : $tscircuit_site_ads['site_3']['img'],
			'img_mobile'	=> ( empty($tscircuit_site_ads['site_3']['img_mobile']) ) ? '' : $tscircuit_site_ads['site_3']['img_mobile'],
			'description'	=> ( empty($tscircuit_site_ads['site_3']['description']) ) ? '' : $tscircuit_site_ads['site_3']['description']
		);
		//if we have minimum info process the splash
		if( !empty($tscircuit_splash['title']) && !empty($tscircuit_splash['link']) && !empty($tscircuit_splash['img']) ) {
			//build the splash html
			$ad_info['splash'] = '<div class="reveal text-center" id="tscircuit_home_reveal" aria-labelledby="' . $tscircuit_splash['title'] . '" data-reveal><div class="relative"><h1 id="reveal-title" class="show-for-sr">' . $tscircuit_splash['title'] . '</h1>';
			//if there is a derscription, add it
			if( !empty($tscircuit_splash['description']) ) $ad_info['splash'] .= '<p class="reveal-description">'. $tscircuit_splash['description'] . '</p>';
			//if there is a mobile image, add it
			if( !empty($tscircuit_splash['img_mobile']) ) $ad_info['splash'] .= '<p class="text-center show-for-small-only"><a href="' . $tscircuit_splash['link'] . '"><img src="'. $tscircuit_splash['img_mobile'] . '" alt="'. $tscircuit_splash['title'] . '" title="'. $tscircuit_splash['title'] . '" /></a></p>';
			//if there is a mobile image, add supporting class to the large image
			$mobile_img_class = ( empty($tscircuit_splash['img_mobile']) ) ? '' : ' show-for-medium';
			//add main splash image
			$ad_info['splash'] .= '<p class="text-center' . $mobile_img_class . '"><a href="' . $tscircuit_splash['link'] . '"><img src="'. $tscircuit_splash['img'] . '" alt="'. $tscircuit_splash['title'] . '" title="'. $tscircuit_splash['title'] . '" /></a></p>';
			//finish up the reveal with the close button and closing div tags
			$ad_info['splash'] .= '<button id="reveal_close_today" class="close-button close-button-friend close-today" data-close aria-label="Close Splash Reveal for Today" type="button"><span aria-hidden="true">Close for Today</span></button> <button class="close-button" data-close aria-label="Close Splash Reveal" type="button"><span aria-hidden="true">&times;</span></button></div></div>';
		}
	}
	return $ad_info;
}

function tscircuit_template_construction( $ele_data ) {
	$tscircuit_admin_form_elements = array(
		'input' 	=> array(
			'template' => '<tr>
					<th>
						<label for="{{element_tag}}">{{element_title}}</label>
						{{element_description}}
					</th>
					<td>
						<input type="{{element_type}}" {{element_limits}} {{element_data}} name="{{element_tag}}" id="{{element_tag}}" value="{{element_value}}">
					</td>
				</tr>',
			'vars'	=> array('tag', 'title', 'description', 'type', 'limits', 'data', 'value')
		),
		'radio' 	=> array(
			'template' => '<tr>
					<th>
						<label for="{{element_tag}}">{{element_title}}</label>
						{{element_description}}
					</th>
					<td>{{element_options}}</td>
				</tr>',
      'template_option' => '<input type="{{element_type}}" {{element_chosen}} name="{{element_tag}}" value="{{element_option}}"> {{element_option_name}} <br />',
			'vars'	=> array('options', 'tag', 'title', 'description', 'type', 'value')
		),
		'rotator' 	=> array(
			'template' => '<figure class="">
					<a href="{{element_link}}" title="{{element_title}} Link" target="_blank">
						<img class="orbit-image" src="{{element_img}}" title="{{element_title}} Image" alt="Click for {{element_title}} Event Information">
					</a>
				</figure>',
			'vars'	=> array('title', 'link', 'img')
		)
	);
	if( empty($ele_data) ) return false;
	$ele = $tscircuit_admin_form_elements[$ele_data['element_type']]['template'];
	foreach( $tscircuit_admin_form_elements[$ele_data['element_type']]['vars'] as $dex => $var ) {
    if( $var === 'options' ) {
      $all_options = '';
      $option_ele = $tscircuit_admin_form_elements[$ele_data['element_type']]['template_option'];
      foreach( $ele_data[$var] as $opt_dex => $opt_details ) {
        $all_options .= str_replace( '{{element_option}}', $opt_details['option'], str_replace( '{{element_option_name}}', $opt_details['option_name'], str_replace( '{{element_chosen}}', (( $opt_details['option'] === $ele_data['value'] ) ? $ele_data['chosen'] : '' ), $option_ele)));
      }
      $ele_data[$var] = $all_options;
    }
		$ele = str_replace( ('{{element_' . $var . '}}'), $ele_data[$var], $ele);
	}
	return $ele;
}

//processes individual incoming datapoints base on typed name key
function tscircuit_process_data_point( $name, $point ) {
	if( empty($name) ) return false;
	$data_process = (is_string($point)) ? trim($point) : $point;
	switch($name) {
		case 'state':
			$data_process = strtoupper(substr($data_process, 0, 2));
		case 'city':
		case 'address':
		case 'country':
		case 'first_name':
		case 'last_name':
		case 'club_abb':
		case 'club_name':
		case 'school_name':
    case 'position_name':
    case 'team_type':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : sanitize_text_field($data_process);
			break;
		case 'name':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? '' : sanitize_text_field($data_process);
			break;
		case 'text':
		case 'notes':
		case 'tagline':
		case 'description':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : sanitize_textarea_field($data_process);
			break;
		case 'videos':
		case 'instagram':
		case 'twitter':
		case 'facebook':
		case 'snapchat':
			if( is_array($data_process) ) {
				foreach( $data_process as $dex => &$val ) $val = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : filter_var($val, FILTER_SANITIZE_URL);
			} else {
				$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : filter_var($data_process, FILTER_SANITIZE_URL);
			}
			break;
		case 'players':
			if( !is_array($data_process) ) $data_process = json_decode($data_process);
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : array_map( function($id_val){ return ( ( is_array($id_val) ) ? array_map( function($sub_id_val){ return intval($sub_id_val); }, $id_val) : intval($id_val)); }, $data_process);
// 			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : array_map( function($id_val){ return gettype($id_val); }, $data_process);
			break;
		case 'social':
			break;
		case 'profile_img':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : sanitize_file_name($data_process);
			break;
		case 'url':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : esc_url_raw($data_process);
			break;
		case 'club_url':
		case 'school_url':
		case 'nickname':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : strtolower(preg_replace("([^a-zA-Z])", "-", preg_replace("([^a-zA-Z -])", "", $data_process)));
			break;
		case 'email':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : sanitize_email($data_process);
			break;
		case 'createtime':
		case 'updatetime':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : substr(preg_replace("([^0-9: -])", "", $data_process),0,18);
			break;
		case 'birthday':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : substr(preg_replace("([^0-9-])", "", $data_process),0,10);
			break;
		case 'phone':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : preg_replace("([^0-9-\(\) ])", "", $data_process);
			break;
		case 'gpa':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : number_format(substr($data_process,0,4), 2);
			break;
		case 'account_level':
		case 'enabled':
		case 'verified':
		case 'height_in':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : intval($data_process);
			break;
		case 'act':
		case 'sat':
		case 'height_ft':
		case 'grad_year':
		case 'weight':
		case 'position':
    case 'position_id':
		case 'zip':
		case 'id':
		case 'club_team':
		case 'club_id':
		case 'school':
		case 'school_id':
		case 'org':
		case 'org_id':
		case 'team_id':
		case 'player_id':
		case 'event_id':
		case 'coach':
		case 'coach_id':
		case 'asst':
		case 'asst_id':
		case 'level':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : intval($data_process);
      if( $data_process === 0 ) $data_process = 'null';
			break;
		case 'player':
		case 'team':
		case 'event':
    case 'ranking':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 0 : intval($data_process);
      break;
		case 'profile_img_data':
			$data_process = ($data_process == null || $data_process == '' || $data_process == 'null') ? 'null' : substr($data_process,strpos($data_process, ",") + 1);
			break;
	}
	return $data_process;
}

//format start and end date based on a 'pipe' separated string
function tscircuit_build_dates($dates, $type = 1, $abbv = false, $add_reg = false) {
	//date is undetermined, don't process
	if( strpos($dates, 'TBD') !== false ) return $dates;
	//if the event is only one day, cut most of the processing
  $start_date = $dates;
	if( strpos($dates, '|') !== false ) {
		$dates = explode('|', $dates);
		$start_date = $dates[0];
    if( $type === 4 ) return $start_date;
		$end_date = end($dates);
		$start_month = explode(' ', $start_date);
		$end_month = explode(' ', $end_date);
		if( $start_month[0] != $end_month[0] ) {
			if( end($start_month) != end($end_month) ) {
				$dates = $start_date . ' - ' . $end_date;
			} else {
        if( $type === 3 ){
          $dates = $start_month[0] . ' ' . substr($start_month[1], 0, -1) . ' - ' . substr($end_month[1], 0, -1);
        } else {
          $dates = $start_month[0] . ' ' . substr($start_month[1], 0, -1) . ' - ' . $end_month[0] . ' ' . substr($end_month[1], 0, -1);
        }
			}
		} else {
			$start_day = substr($start_month[1], 0, -1);
			$end_day = substr($end_month[1], 0, -1);
			if( $start_day == $end_day ) {
				$dates = $start_month[0] . ' ' . substr($start_month[1], 0, -1);
			} else {
				$dates = $start_month[0] . ' ' . substr($start_month[1], 0, -1) . ' - ' . substr($end_month[1], 0, -1);
			}
		}
		switch( $type ){
			case 1:
				break;
			case 2:
				$dates .= ', ' . end($end_month);
        $dates = preg_replace('/ \- /', '-', $dates);
				break;
			case 3:
				break;
		}
	} else {
		switch( $type ){
			case 1:
				$dates = explode(' ', $dates);
				if( strpos($dates[1], ',') !== false ) $dates[1] = substr($dates[1], 0, -1);
				$dates = $dates[0] . ' ' . $dates[1];
				break;
			case 2:
        $dates = preg_replace('/ \- /', '-', $dates);
				break;
			case 3:
				$dates = explode(' ', $dates);
				if( strpos($dates[1], ',') !== false ) $dates[1] = substr($dates[1], 0, -1);
				$dates = $dates[0] . ' ' . $dates[1];
				break;
      case 4:
        return $dates;
        break;
		}
	}
  if( $abbv ) return preg_replace('/([A-Za-z]{3})( |.+? )/', '\1 ', $dates);
  if( $add_reg !== false ) {
    $registration_date = 'No registration deadline.';
    if( $add_reg !== 0 ) {
      $registration_date = date('F d, Y', strtotime('-' . intval($add_reg) . ' days', strtotime($start_date)));
    }
    return array($dates, $registration_date);
  }
	return $dates;
}

function g365_event_data_proc( $atts ) {
	$atts = shortcode_atts( array(
		'data_set' => '',
    'reg_days' => false
	), $atts, 'g365_event_data' );
  if( $atts['data_set'] === '' ) return '<p>Add Attributes.</p>';
  $data_sets = explode(',', $atts['data_set']);
  $event_object = get_post_meta( get_the_ID(), '_event_link_data', true );
  if( empty( $event_object ) ) return;
  $data_compile = '';
  foreach( $data_sets as $dex => $type ){
    switch( $type ){
      case 'location':
        $event_locations = explode('|', $event_object->locations);
        $data_compile .= '<h3>Location</h3><p>';
        if( empty($event_locations) ) {
          $data_compile .= 'TBD';
        } else {
          foreach( $event_locations as $loc_dex => $loc ){
            $data_compile .= '<a class="tiny-margin-bottom in-block" href="https://www.google.com/maps/search/' . preg_replace('/[^a-zA-Z0-9,]/', '+', $loc) . '/" target="_blank">' . $loc . '</a>';
            if( count($event_locations) !== $loc_dex + 1 ) $data_compile .= '<br>'; 
          }
        }
        $data_compile .= '</p>';
        break;
      case 'date':
        $data_compile .= '<h3>Dates</h3><p>';
        if( empty($event_object->dates) ) {
          $data_compile .= 'TBD';
        } else {
          $reg_days = $atts['reg_days'];
          $date_reg = tscircuit_build_dates($event_object->dates, 2, false, $reg_days);
          if( $reg_days === false ) {
            $data_compile .= $date_reg;
          } else {
            $data_compile .= $date_reg[0];
            $data_compile .= ( empty($date_reg[1]) ) ? '' : '<h3>Registration Deadline</h3><p><strong>' . $date_reg[1] . '</strong><small class="block"><em>' . $reg_days . ' days prior to tournament.</em></small></p>';
          }
        }
        $data_compile .= '</p>';
        break;
      case 'full_address':
        if( empty($event_object->short_locations) ) {
          $data_compile .= 'TBD';
        } else {
          $reg_days = $atts['reg_days'];
          $date_reg = tscircuit_build_dates($event_object->short_locations, 2, false, $reg_days);
          if( $reg_days === false ) {
            $data_compile .= $date_reg;
          } else {
            $data_compile .= $date_reg[0];
            $data_compile .= ( empty($date_reg[1]) ) ? '' : '<h3>Registration Deadline</h3><p><strong>' . $date_reg[1] . '</strong><small class="block"><em>' . $reg_days . ' days prior to tournament.</em></small></p>';
          }
        }
        $data_compile .= '</p>';
        break;
    }
  }
	return $data_compile;
}
add_shortcode( 'g365_event_data', 'g365_event_data_proc' );

//player spotlight
function g365_player_spotlight_build( $atts ) {
  $player_spotlights_arr = g365_conn( 'g365_get_awards_featured', [false, 4] );
  $return_string = '';
  if( !empty($player_spotlights_arr) ) {
    $return_string = '<div class="grid-x grid-margin-x small-up-2 medium-up-4 text-center profile-feature profile-widget">';
    foreach( $player_spotlights_arr as $dex => $obj ) {
      $return_string .= '<div class="cell"><div class="gfont small-margin-bottom"><!-- callout gset --><h5 class="weight-bold no-margin-bottom">';
      $return_string .= '<a href="https://grassroots365.com/player/' . $obj->player_url . '" target="_blank" title="Official Grassroots365 Player Profile for ' . $obj->player . '">' . $obj->player . '</a>';
      $return_string .= '</h5><div class="relative green-border"><!--<div class="award-title">Defense</div> -->';
      $return_string .= '<a href="https://grassroots365.com/player/' . $obj->player_url . '" target="_blank" title="Official Grassroots365 Player Profile for ' . $obj->player . '">';
      $return_string .= '<img src="' . ((!empty($obj->player_profile_img)) ? $obj->player_profile_img : $default_profile_img) . '" alt="' . $obj->player . ' at ' . $obj->event . '" />';
      $return_string .= '</a></div><a class="button hollow expanded" href="https://grassroots365.com/event/' . $obj->event_url . '" target="_blank">' . $obj->event . '</a></div></div>';
    }
    $return_string .= '</div>';
  }
  return $return_string;
}
add_shortcode( 'g365_player_splotlight', 'g365_player_spotlight_build' );


//convert a graduation year to current grade
function g365_class_to_grade($class_of, $add_suffix = false) {
  if( empty($class_of) || !is_numeric($class_of) ) return 'N/A';
  $today = date("Y-m-d");
  $grade_string = (12 - (intval($class_of) - date('Y', strtotime($today)) - (( intval(date('n', strtotime($today))) < 8 ) ? 0 : 1 )));
  if( $add_suffix ) {
    switch( $grade_string ) {
      case '1':
        $grade_string .= '<sup>st</sup>';
        break;
      case '2':
        $grade_string .= '<sup>nd</sup>';
        break;
      case '3':
        $grade_string .= '<sup>rd</sup>';
        break;
      default:
        $grade_string .= '<sup>th</sup>';
        break;
    }
  }
  return $grade_string;
}


/*
Plugin Name: Extend Blocks
*/

function guten_extend_enqueue() {
  wp_enqueue_script( 'guten-extend_blocks',
    get_stylesheet_directory_uri() . '/inc/guten-extend_blocks.js',
    array( 'wp-blocks' )
  );
}
add_action( 'enqueue_block_editor_assets', 'guten_extend_enqueue' );

// Set current date time as custom item data
add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_data_timestamp', 10, 3 );
function add_cart_item_data_timestamp( $cart_item_data, $product_id, $variation_id ) {
    // Set the shop time zone (List of Supported Timezones: https://www.php.net/manual/en/timezones.php)
    date_default_timezone_set( 'America/Los_Angeles' );

    $cart_item_data['timestamp'] = strtotime( date('Y-m-d h:i:s') );

    return $cart_item_data;
}

// Empty cart after 2 hours
add_filter( 'template_redirect', 'empty_cart_after_3_days' );
function empty_cart_after_3_days(){
    if ( WC()->cart->is_empty() ) return; // Exit

    // Set the shop time zone (List of Supported Timezones: https://www.php.net/manual/en/timezones.php)
    date_default_timezone_set( 'America/Los_Angeles' );

    // Set the threshold time in seconds (2 hours in seconds)
    $threshold_time  = 2 * 60 * 60;

    $cart_items      = WC()->cart->get_cart(); // get cart items
    $cart_items_keys = array_keys($cart_items); // get cart items keys array
    $last_item       = end($cart_items); // Last cart item
    $last_item_key   = end($cart_items_keys); // Last cart item key
    $now_timestamp   = strtotime( date('Y-m-d h:i:s') ); // Now date time

    if( isset($last_item['timestamp']) && ( $now_timestamp - $last_item['timestamp'] ) >= $threshold_time ) {
        WC()->cart->empty_cart(); // Empty cart
    }
}

add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );
function override_billing_checkout_fields( $fields ) {
    $fields['billing']['billing_first_name']['placeholder'] = 'First Name';
    $fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
    $fields['billing']['billing_company']['placeholder'] = 'Company (optional)';
    $fields['billing']['billing_city']['placeholder'] = 'City';
    $fields['billing']['billing_postcode']['placeholder'] = 'Zip Code';
    $fields['billing']['billing_phone']['placeholder'] = 'Phone';
    $fields['billing']['billing_email']['placeholder'] = 'Email';
    return $fields;
}

function g365_start_ads( $pageID ){
// 	$pageID = ( $pageID === null ) ? $post->ID : $pageID;
	//see if we have any ads on this page
	$g365_page_ad = array(
		'title'	=> get_post_meta($pageID, 'ad_title', true),
		'link'	=> get_post_meta($pageID, 'ad_link', true),
		'img'		=> get_post_meta($pageID, 'ad_img', true),
		'element_type'	=> 'rotator'
	);
	//get site global ad settings
	$g365_site_ads = get_option( 'g365_display' );

  //if the page doesn't have an ad or the site global is empty, don't add to array
	$ad_info['go'] = ( empty($g365_page_ad['link']) || empty($g365_page_ad['img']) || empty($g365_site_ads) ) ? false : true;
	//general header banner ads GOOOO!
	if ( $ad_info['go'] ) {
		$ad_info = array(
			'go' => true,
			'ad_section_class'	=> ' no-padding-top',
			'ad_before'	=> '<div id="event_display_rotator" class="slick display-wrapper small-small-margin-bottom large-margin-bottom" role="region" aria-label="Upcoming Events">',
			'ad_content'	=> '',
			'ad_after'	=> '</div>'
		);
		//future functionality, ad treatment type
		$g365_site_ads['site_1']['element_type'] = 'rotator';
		$g365_site_ads['site_2']['element_type'] = 'rotator';
		//build rotator element for page ad
		$ad_info['ad_content'] .= g365_template_construction( $g365_page_ad );
		//if we have a global ad, build and add it
		if( !empty($g365_site_ads['site_1']['img']) ) $ad_info['ad_content'] .= g365_template_construction( $g365_site_ads['site_1'] );
		//if we have a secondary global ad, build if and add it along with another primary ad to help the flow
		if( !empty($g365_site_ads['site_2']['img']) ) {
			$ad_info['ad_content'] .= g365_template_construction( $g365_page_ad );
			$ad_info['ad_content'] .= g365_template_construction( $g365_site_ads['site_2'] );
		}
	}
	//on the front page, and if we have a global splash setting
	if( is_front_page() && !empty($g365_site_ads['site_3']) ) {
		//controls for the splash
		$g365_splash = array(
			'title'				=> ( empty($g365_site_ads['site_3']['title']) ) ? '' : $g365_site_ads['site_3']['title'],
			'link'				=> ( empty($g365_site_ads['site_3']['link']) ) ? '' : $g365_site_ads['site_3']['link'],
			'img'					=> ( empty($g365_site_ads['site_3']['img']) ) ? '' : $g365_site_ads['site_3']['img'],
			'img_mobile'	=> ( empty($g365_site_ads['site_3']['img_mobile']) ) ? '' : $g365_site_ads['site_3']['img_mobile'],
			'description'	=> ( empty($g365_site_ads['site_3']['description']) ) ? '' : $g365_site_ads['site_3']['description']
		);
		//if we have minimum info process the splash
		if( !empty($g365_splash['title']) && !empty($g365_splash['link']) && !empty($g365_splash['img']) ) {
			//build the splash html
			$ad_info['splash'] = '<div class="reveal text-center" id="g365_home_reveal" aria-labelledby="' . $g365_splash['title'] . '" data-reveal><div class="relative"><h1 id="reveal-title" class="show-for-sr">' . $g365_splash['title'] . '</h1>';
			//if there is a derscription, add it
			if( !empty($g365_splash['description']) ) $ad_info['splash'] .= '<p class="reveal-description">'. $g365_splash['description'] . '</p>';
			//if there is a mobile image, add it
			if( !empty($g365_splash['img_mobile']) ) $ad_info['splash'] .= '<p class="text-center show-for-small-only"><a href="' . $g365_splash['link'] . '"><img src="'. $g365_splash['img_mobile'] . '" alt="'. $g365_splash['title'] . '" title="'. $g365_splash['title'] . '" /></a></p>';
			//if there is a mobile image, add supporting class to the large image
			$mobile_img_class = ( empty($g365_splash['img_mobile']) ) ? '' : ' show-for-medium';
			//add main splash image
			$ad_info['splash'] .= '<p class="text-center' . $mobile_img_class . '"><a href="' . $g365_splash['link'] . '"><img src="'. $g365_splash['img'] . '" alt="'. $g365_splash['title'] . '" title="'. $g365_splash['title'] . '" /></a></p>';
			//finish up the reveal with the close button and closing div tags
			$ad_info['splash'] .= '<button id="reveal_close_today" class="close-button close-button-friend close-today" data-close aria-label="Close Splash Reveal for Today" type="button"><span aria-hidden="true">Close for Today</span></button> <button class="close-button" data-close aria-label="Close Splash Reveal" type="button"><span aria-hidden="true">&times;</span></button></div></div>';
		}
	}
	return $ad_info;
}

//retrieve awards data
//build awards widget
function g365_build_awards( $group = null, $args = null ) {
	if( $group === null ) return 'Need group id to pull data.';
	//get data groups
	$groups = g365_get_groups_data( $group, 3 );
	//if the group data is empty or an error message, send it back
	if( empty($groups) || gettype($groups) == 'string' ) return $groups;
	//make the search string for award retrieval
	$award_id_list = 'IN (' . implode(',',$groups->item_ids) . ')';
	global $wpdb;
	$wpdb_awards = $wpdb->g365_awards;
	$wpdb_award_refs = $wpdb->g365_award_refs;
	$wpdb_players = $wpdb->g365_players;
	$wpdb_events = $wpdb->g365_events;
	$wpdb_stats = $wpdb->g365_stats;
	//Pull full list of awards for the tables
	$awards = $wpdb->get_results(
		"SELECT DISTINCT refs.name AS award_name, refs.class AS award_class,
		ev.id AS event_id, events.nickname AS event_nickname, refs.event, refs.award, 
		pl.name AS player_name, pl.id AS player_id, pl.nickname AS player_url, pl.birthday AS player_birthday,
		aw.name AS award_label, aw.logo_img, aw.type AS award_type,
		st.profile_img AS profile_img
		FROM $wpdb_award_refs AS refs
		LEFT JOIN $wpdb_award_refs AS ev ON refs.event=ev.id
    LEFT JOIN $wpdb_events AS events
    ON events.id = refs.event
		LEFT JOIN $wpdb_players AS pl ON refs.player=pl.id
		LEFT JOIN $wpdb_awards AS aw ON refs.award=aw.id
		LEFT JOIN $wpdb_stats AS st ON st.player = refs.player AND st.event=refs.event AND st.profile_img IS NOT NULL
		WHERE refs.event $award_id_list
		ORDER BY refs.event, FIELD(refs.award, 1, 5, 4, 3, 9, 2, 10, 6, 7, 12, 11, 14, 16), FIELD(refs.class, 1, 2, 3, 4, 5, 6, 7, 8, 171, 324, 325, 172, 173, 174, 175, 9, 10, 119, 120, 121, 122, 176, 177, 123, 216, 11, 271, 272, 301, 318, 240, 12, 319, 124, 125, 126, 127, 178, 179, 128, 242, 202, 228, 229, 13, 239, 304, 305, 241, 14, 129, 130, 131, 132, 133, 203, 274, 273, 243, 164, 165, 15, 16, 275, 134, 135, 326, 302, 303, 136, 137, 138, 204, 306, 307, 244, 250, 230, 231, 180, 181, 17, 18, 139, 140, 141, 182, 183, 142, 162, 163, 143, 205, 327, 328, 245, 232, 251, 233, 234, 160, 161, 19, 159, 20, 144, 145, 146, 147, 148, 206, 246, 252, 322, 321, 253, 185, 186, 166, 167, 184, 21, 169, 170, 22, 149, 150, 151, 23, 24, 25, 26, 168, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 153, 154, 60, 61, 155, 156, 157, 158, 62, 63, 64, 65, 308, 309, 310, 66, 67, 68, 69, 70, 71, 72, 311, 73, 74, 312, 75, 76, 313, 77, 78, 79, 287, 288, 289, 80, 81, 290, 317, 291, 292, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 276, 314, 277, 278, 279, 101, 197, 198, 199, 200, 201, 207, 212, 214, 215, 217, 218, 235, 236, 247, 254, 255, 261, 264, 265, 266, 267, 323, 320, 280, 281, 282, 283, 102, 193, 194, 195, 196, 208, 209, 211, 219, 220, 221, 222, 223, 248, 256, 257, 262, 268, 269, 270, 103, 284, 315, 329, 285, 316, 286, 187, 188, 189, 190, 191, 192, 210, 213, 224, 225, 226, 227, 237, 249, 259, 263, 300, 299, 298, 297, 296, 295, 294, 293 ,260, 238, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118);"
	);
  //check for the truncate flag
  if( $args['truncate'] === true ) {
    $groups->awards = $awards;
    return $groups;
  }
	//reformat data to be organized by event id
	$awards_process =  new stdClass();
	//add a data point to track which events actually have award data associated with them
	$groups->data_present = array();
	foreach( $awards as $dex => $vals ) {
		//organize award data by event_id->award_id[grad_class][award_item]
		if( !isset($awards_process->{$vals->event_id}) ) $awards_process->{$vals->event_id} = new stdClass();
    $awards_process->{$vals->event_id}->{$vals->award_type}[$vals->award_class][] = $vals;
		//add event id to positive data array if we don't already have it
		if( !in_array($vals->event_id, $groups->data_present) ) $groups->data_present[] = $vals->event_id;
	}
	//add awards to main object
	$groups->awards = $awards_process;
	return $groups;
}


//retrieve groups and groups of groups
function g365_get_groups_data( $group = null, $type = null, $args = null ) {
//   echo("<script>console.log('test ');</script>");
	if( $group === null ) return 'Need group to pull data.';
	global $wpdb;
	$wpdb_groups = $wpdb->g365_groups;
  $enabled = 'AND `enabled` = 1';
  $enabled_ref = 'AND gr.enabled = 1';
  $enabled_part = 'enabled = 1';
  if( !is_null($args) && isset($args['enabled']) ) {
    if( is_numeric($args['enabled']) ) {
      $enabled = 'AND `enabled` = ' . intval($args['enabled']);
      $enabled_ref = 'AND gr.enabled = ' . intval($args['enabled']);
      $enabled_part = 'enabled = ' . intval($args['enabled']);
    } else {
      $enabled = '';
      $enabled_ref = '';
      $enabled_part = '';
    }
  }
	//if you have an id, go straigth there, otherwise see what we find with a name
	if( is_numeric($group) ) {
		$group = $wpdb->get_results(
			"SELECT * FROM $wpdb_groups WHERE `id` = $group $enabled;"
		);
	} else {
		//narrow the search by group type org, event, series
		$sql_type = ( $type === null || $type < 1 ) ? '' : "AND `type` = $type"; 
		$group = $wpdb->get_results(
			"SELECT * FROM $wpdb_groups WHERE `nickname` LIKE '$group' $sql_type $enabled;"
		);
	}
	if( empty($group) ) return 'No groups found.';
	//it the result is ambiguous then return the data for refinement
	if( count($group) > 1 || $type < 0 ) return $group;
	//simplify the data reference
	$group = $group[0];
	if( $group->groups != 1 && $type === 0 ) return $group;
	//the second phase is pulling the group references
	$wpdb_group_refs = $wpdb->g365_group_refs;
  $wpdb_events = $wpdb->g365_events;
	//extract the group id for use in the query
	$group_id = $group->id;
	//if the group is a group of groups do the diligence
	if( $group->groups == 1 ) {
		//get the list of subgroups
    switch($group_id) {
      case 44:
    		//for the master calendar...put it in this order...
        $group->records = $wpdb->get_results(
          "SELECT gr.*
          FROM $wpdb_group_refs AS refs
          LEFT JOIN $wpdb_groups AS gr ON refs.item_id=gr.id
          WHERE refs.group_id = $group_id $enabled_ref
          ORDER BY FIELD(gr.id,43,8,13,12,168,169,170,283,284);"
        );
        break;
      case 24:
        //for EBC Camps...put it in this order...
        $group->records = $wpdb->get_results(
          "SELECT gr.*
          FROM $wpdb_group_refs AS refs
          LEFT JOIN $wpdb_groups AS gr ON refs.item_id=gr.id
          WHERE refs.group_id = $group_id $enabled_ref
          ORDER BY FIELD(gr.id,23,22,14,15,63,16,17,18,19,20,21,54,64);"
        );
        break;
      case 89:
        if(!empty($args['tsc_only']) && $args['tsc_only'] === true){ $tsc_only = " AND gr.name LIKE ('%The Stage%') "; }else{ $tsc_only = ''; }
        //for all-tournament awards...put it in this order...
        $group->records = $wpdb->get_results(
          "SELECT gr.*, (
          SELECT ev_ref.eventtime 
          FROM $wpdb_group_refs AS sub_group_ref 
          LEFT JOIN $wpdb_events AS ev_ref ON sub_group_ref.item_id=ev_ref.id
          WHERE gr.id=sub_group_ref.group_id ORDER BY ev_ref.eventtime LIMIT 1
          ) AS eventtime, (
          SELECT ev_ref.org 
          FROM $wpdb_group_refs AS sub_group_ref 
          LEFT JOIN $wpdb_events AS ev_ref ON sub_group_ref.item_id=ev_ref.id
          WHERE gr.id=sub_group_ref.group_id ORDER BY ev_ref.eventtime LIMIT 1
          ) AS ev_org
          FROM $wpdb_group_refs AS refs
          LEFT JOIN $wpdb_groups AS gr ON refs.item_id=gr.id
          WHERE refs.group_id = $group_id $enabled_ref $tsc_only
          ORDER BY eventtime DESC;"
        );
        break;
      case 287:
    		//for the master calendar...put it in this order...
        $group->records = $wpdb->get_results(
          "SELECT gr.*
          FROM $wpdb_group_refs AS refs
          LEFT JOIN $wpdb_groups AS gr ON refs.item_id=gr.id
          WHERE refs.group_id = $group_id $enabled_ref
          ORDER BY FIELD(gr.id,288,8,286,13,12,168,169,170,283,284);"
        );
        break;
       case 342:
    		//for the master calendar...put it in this order...
        $group->records = $wpdb->get_results(
          "SELECT gr.*
          FROM $wpdb_group_refs AS refs
          LEFT JOIN $wpdb_groups AS gr ON refs.item_id=gr.id
          WHERE refs.group_id = $group_id $enabled_ref
          ORDER BY FIELD(gr.id,343,8,286,13,12,168,169,170,283,284,346,347,348);"
        );
        break;
      default:
        //defaults to no order
        $group->records = $wpdb->get_results(
          "SELECT gr.*
          FROM $wpdb_group_refs AS refs
          LEFT JOIN $wpdb_groups AS gr ON refs.item_id=gr.id
          WHERE refs.group_id = $group_id $enabled_ref;"
        );
    }
		//if we only want the list of sub groups output now
		if( $type === 0 ) return $group;
		//make the search list for the subgroup pull
		$group_id_list = array();
		foreach( $group->records as $dex => $sub_group ) {
			$group_id_list[] = $sub_group->id;
		}
		//format for sql query
		$group_id_list = 'IN (' . implode(',',$group_id_list) . ')';
	} else {
		$group_id_list = "= $group_id";
	}
  //return only the groups
  if(!empty($args['truncate'])){
    if( $args['truncate'] === true ) return $group;
  }
  //attach the data that the groups are pointing at
	switch( $type ) {
		case 0: //sub groups
      $enabled_part = 'AND gr.' . $enabled_part;
			$group_ref_data = $wpdb->get_results(
				"SELECT gr.*
				FROM $wpdb_group_refs AS refs
				LEFT JOIN $wpdb_groups AS gr ON refs.item_id=gr.id
				WHERE refs.group_id $group_id_list $enabled_part;"
			);
			break;
		case 1: //orgs
			$wpdb_orgs = $wpdb->g365_orgs;
      $enabled_part = 'AND org.' . $enabled_part;
			$group_ref_data = $wpdb->get_results(
				"SELECT org.*, refs.group_id
				FROM $wpdb_group_refs AS refs
				LEFT JOIN $wpdb_orgs AS org ON refs.item_id=org.id
				WHERE refs.group_id $group_id_list $enabled_part;"
			);
			break;
		case 2: //events asc
			$wpdb_events = $wpdb->g365_events;
      $enabled_part = 'AND ev.' . $enabled_part;
			$group_ref_data = $wpdb->get_results(
				"SELECT ev.*, refs.group_id
				FROM $wpdb_group_refs AS refs
				LEFT JOIN $wpdb_events AS ev ON refs.item_id=ev.id
				WHERE refs.group_id $group_id_list $enabled_part
				ORDER BY ev.eventtime;"
			);
			break;
		case 3: //events desc
			$wpdb_events = $wpdb->g365_events;
      $enabled_part = 'AND ev.' . $enabled_part;
			$group_ref_data = $wpdb->get_results(
				"SELECT ev.*, refs.group_id
				FROM $wpdb_group_refs AS refs
				LEFT JOIN $wpdb_events AS ev ON refs.item_id=ev.id
				WHERE refs.group_id $group_id_list $enabled_part
				ORDER BY ev.eventtime DESC;"
			);
			break;
		case 4: //rankings
			$wpdb_rankings = $wpdb->g365_rankings;
			//create date based array for subnavigation
			$group->ranking_brackets = $wpdb->get_results(
				"SELECT DISTINCT start_datetime, end_datetime
				FROM $wpdb_rankings
				WHERE group_id $group_id_list $enabled
				ORDER BY start_datetime DESC;"
			);
			//if there is limit data use it otherwise assume we are pulling the lastest data
			$min_limit = ( empty($args['min-limit']) ? date("Y-m-d", strtotime($group->ranking_brackets[0]->start_datetime)) : date("Y-m-d", strtotime($args['min-limit'])) );
			$max_limit = ( empty($args['max-limit']) ? date("Y-m-d", strtotime($group->ranking_brackets[0]->end_datetime)) : date("Y-m-d", strtotime($args['max-limit'])) );
			//different stipulations if we are looking for the ranking at a specific time
// 			$date_limit = 'AND `start_datetime` >= "' . $min_limit . '" AND `end_datetime` <= "' . $max_limit . '"';
			$date_limit = "AND `start_datetime` >= '" . $min_limit . "' AND `end_datetime` <= '" . $max_limit . "'";
			$group_ref_data = $wpdb->get_results(
				"SELECT *
				FROM $wpdb_rankings
				WHERE group_id $group_id_list $date_limit $enabled
				ORDER BY group_id ASC, ranking_type DESC;"
			);
			break;
		default:
			return "Can't find group type to finish data processing.";
			break;
	}
	//if this is a group of groups, organize the data into sections then make lists of the contained group ids
	//otherwise make the id list and append the records
	$group->item_ids = array();
	if( $group->groups == 1 ) {
		foreach( $group->records as $dex => &$record ) {
			$record->item_ids = array();
			$record->records = array();
			foreach( $group_ref_data as $subdex => $subrecord ) {
				if( $record->id == $subrecord->group_id ) {
					$record->records[] = $subrecord;
					$group->item_ids[] = $subrecord->id;
					$record->item_ids[] = $subrecord->id;
				}
			}
		}
	} else {
		foreach( $group_ref_data as $dex => $record ) {
			$group->item_ids[] = $record->id;
		}
		$group->records = $group_ref_data;
	}
	return $group;
}

//format start and end date based on a 'pipe' separated string
function g365_build_dates($dates, $type = 1, $abbv = false, $add_reg = false) {
	//date is undetermined, don't process
	if( strpos($dates, 'TBD') !== false ) return $dates;
  //set default timezone
  date_default_timezone_set('America/Los_Angeles');
	//if the event is only one day, cut most of the processing
  $start_date = $dates;
  //if the date does have the "|" jump to bottom
	if( strpos($dates, '|') !== false ) {
		$dates = explode('|', $dates);
    //if we want just the dates, only first and last
    if( $type === 5 ) {
      return array( date("m-d-y", strtotime($dates[0])), date("m-d-y", strtotime(end($dates))) );
    }
		$start_date = $dates[0];
    if( $type === 4 ) return $start_date;
		$end_date = end($dates);
		$start_month = explode(' ', $start_date);
		$end_month = explode(' ', $end_date);
		if( $start_month[0] != $end_month[0] ) {
			if( end($start_month) != end($end_month) ) {
        $dates = $start_date . ' - ' . $end_date . $type;
			} else {
        if( $type === 3 ){
          $dates = $start_month[0] . ' ' . substr($start_month[1], 0, -1) . ' - ' . substr($end_month[1], 0, -1);
        } else {
          $dates = $start_month[0] . ' ' . substr($start_month[1], 0, -1) . ' - ' . $end_month[0] . ' ' . substr($end_month[1], 0, -1);
        }
			}
		} else {
			$start_day = substr($start_month[1], 0, -1);
			$end_day = substr($end_month[1], 0, -1);
			if( $start_day == $end_day ) {
				$dates = $start_month[0] . ' ' . substr($start_month[1], 0, -1);
			} else {
				$dates = $start_month[0] . ' ' . substr($start_month[1], 0, -1) . ' - ' . substr($end_month[1], 0, -1);
			}
		}
		switch( $type ){
			case 1:
				break;
			case 2:
				$dates .= ', ' . end($end_month);
        $dates = preg_replace('/ \- /', '-', $dates);
				break;
			case 3:
				break;
		}
	} else {
		switch( $type ){
			case 1:
				$dates = explode(' ', $dates);
				if( strpos($dates[1], ',') !== false ) $dates[1] = substr($dates[1], 0, -1);
				$dates = $dates[0] . ' ' . $dates[1];
				break;
			case 2:
				break;
			case 3:
				$dates = explode(' ', $dates);
				if( strpos($dates[1], ',') !== false ) $dates[1] = substr($dates[1], 0, -1);
				$dates = $dates[0] . ' ' . $dates[1];
				break;
      case 4:
        return $dates;
        break;
		}
	}
  if( $abbv ) return preg_replace('/([A-Za-z]{3})( |.+? )/', '\1 ', $dates);
  if( $add_reg !== false ) {
    $registration_date = 'No registration deadline.';
    if( $add_reg !== 0 ) {
      $registration_date = date('F d, Y', strtotime('-' . intval($add_reg) . ' days', strtotime($start_date)));
    }
    return array($dates, $registration_date);
  }
	return $dates;
}
//format location info based on 'pipe' separated string
function g365_build_locations($locations, $type = 0) {
//     case 3:
//     case 2:
//     case 1:
//       if( strpos($locations, 'TBD') !== false ) return $locations;
//       $locations = explode('|', $locations);
//       $location_build = array();
//       foreach ($locations as $location) {
//         $loc_parts = explode(",", $location);
//         $acronym = '';
//         foreach (explode(" ", $loc_parts[0]) as $w) {
//           $acronym .= ( ctype_upper($w) ) ? ((empty($acronym)) ? $w : ' ' . $w ) : $w[0];
//         }
//         switch ($type) {
//           case 3:
//             $location_build[] = $acronym;
//             break;
//           case 2:
//             $loc_parts[0] = $acronym;
//             $location_build[] = (( $loc_parts[0] === end($loc_parts) ) ? $acronym : $acronym . ', ' . end($loc_parts));
//             break;
//           case 1:
//             $loc_parts[0] = $acronym;
//             $location_build[] = implode($loc_parts, ', ');
//             break;
//         }
//       }
//       $locations = implode($location_build, ' | ');  
//       break;
  if( empty($locations) ) return $locations;
  switch( $type ) {
    case 3:
    case 2:
      if( strpos($locations, 'TBD') !== false ) return $locations;
      $locations = explode('|', $locations);
      $location_build = array();
      foreach ($locations as $location) {
        $loc_parts = explode(",", $location);
        switch ($type) {
          case 3:
            $location_build[] = $loc_parts[0];
            break;
          case 2:
            $location_build[] = (( $loc_parts[0] === end($loc_parts) ) ? $loc_parts[0] : $loc_parts[0] . ' (' . end($loc_parts) . ')');
            break;
        }
      }
      $locations = implode($location_build, ' | ');  
      break;
    case 1:
      break;
    default:
      $locations = explode('|', $locations);
//       $locations = implode($locations, '<br>');      
      $locations = implode('<br>', $locations);      
  }
	return $locations;
}


?>